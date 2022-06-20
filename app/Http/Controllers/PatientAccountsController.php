<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class PatientAccountsController extends Controller
{

    public function __construct()
    {

        $AbsCCounter = DB::table('patient_accounts')
            ->where('Balance', '<', 0)
            ->count();

        if ($AbsCCounter > 0) {

            $AbsSetter = DB::table('patient_accounts')
                ->where('Balance', '<', 0)
                ->get();

            foreach ($AbsSetter as $data) {

                DB::table('patient_accounts')->where('id', $data->id)->update([

                    'Balance' => abs($data->Balance),
                ]);
            }

        }

        $A_counter = DB::table('patient_accounts')
            ->where('_unique', 'NULL')
            ->orWhere('_unique', null)
            ->orWhere('_unique', ' ')
            ->count();

        if ($A_counter > 0) {

            $Emails = DB::table('patient_accounts')
                ->where('_unique', 'NULL')
                ->orWhere('_unique', null)
                ->orWhere('_unique', ' ')->get();

            foreach ($Emails as $data) {

                DB::table('patient_accounts')->where('id', $data->id)->update([

                    "_unique" => md5(\Hash::make(uniqid())),

                ]);
            }
        }
    }

    public function PatientCreditManagement()
    {

        $Credit = DB::table('patient_accounts')
            ->where('OutstandingStatus', 'PartialCredit')
            ->groupBy('PatientEmail')
            ->selectRaw('sum(Outstanding) as CreditAmount,  PatientEmail, PatientName, PatientPhone, id, _unique'
            )->get();

        $data = [

            "Page"   => "patients.PatientCredit",
            "Title"  => "Manage Patient Credit",
            "Desc"   => "Patient Credit Report",
            "Credit" => $Credit,

        ];

        return view('scrn', $data);
    }

    public function GenerateCreditClearanceDates()
    {

        $counter = DB::table('credit_payment_logs')
            ->whereNull('Month')
            ->whereNull('Year')
            ->count();

        if ($counter > 0) {

            $up = DB::table('credit_payment_logs')
                ->whereNull('Month')
                ->whereNull('Year')
                ->get();

            foreach ($up as $data) {
                DB::table('credit_payment_logs')->where('id', $data->id)->update([

                    'Month' => date('m', strtotime($data->created_at)),
                    'Year'  => date('Y', strtotime($data->created_at)),

                ]);
            }
        }

    }

    public function ClearDebtNow($unique)
    {
        $Credit = DB::table('patient_accounts')
            ->where('OutstandingStatus', 'PartialCredit')
            ->where('_unique', $unique)
            ->get();

        $credit_payment_logs = DB::table('credit_payment_logs AS L')
            ->where('L._unique', $unique)
            ->join('payment_methods AS P', 'P.PaymentID', 'L.PaymentMethod')
            ->select('L.*', 'P.PaymentMethod')
            ->get();

        $payment_methods = DB::table('payment_methods')
            ->where('PaymentMethod', 'not like', '%Insurance%')
            ->where('PaymentMethod', 'not like', '%Credit%')
            ->where('PaymentMethod', 'not like', '%Hospital Billable%')
            ->get();

        $data = [

            "Page"                => "patients.ClearDebt",
            "Title"               => "Record credit Payment For the Selected Patient",
            "Desc"                => "Record credit Payment",
            "credit_payment_logs" => $credit_payment_logs,
            "payment_methods"     => $payment_methods,
            "Credit"              => $Credit,

        ];

        return view('scrn', $data);
    }

    public function RecordDebtPay(Request $request)
    {
        $validated = $this->validate($request, [
            '*' => 'required',
        ]);

        $Credit = DB::table('patient_accounts')
            ->where('_unique', $request->unique)
            ->first();

        $AmountPaid  = $request->AmountPaid;
        $Outstanding = $Credit->Outstanding - $request->AmountPaid;

        if ($Outstanding <= 0) {

            DB::table('patient_accounts')->where('_unique', $request->unique)->delete();

            DB::table('credit_payment_logs')
                ->insert([

                    'uuid'          => md5($request->unique),
                    'PaymentMethod' => $request->PaymentMethod,
                    '_unique'       => $request->unique,
                    'AmountPaid'    => $AmountPaid,
                    'Outstanding'   => 0,
                    'RegisteredBy'  => \Auth::user()->name,
                    'created_at'    => date('Y-m-d'),
                ]);

            $this->GenerateCreditClearanceDates();

            return redirect()->back()->with('status', 'Full Credit Payment Recorded and a permanent log has been created', 'successful');
        } else {

            DB::table('patient_accounts')->where('_unique', $request->unique)->update([

                "Outstanding" => $Outstanding,

            ]);

            DB::table('credit_payment_logs')
                ->insert([
                    'uuid'          => md5($request->unique),
                    'PaymentMethod' => $request->PaymentMethod,
                    '_unique'       => $request->unique,
                    'AmountPaid'    => $AmountPaid,
                    'Outstanding'   => $Outstanding,
                    'RegisteredBy'  => \Auth::user()->name,
                    'created_at'    => date('Y-m-d'),
                ]);

            $this->GenerateCreditClearanceDates();

            return redirect()->back()->with('status', 'Partial Credit Payment Recorded and a permanent log has been created', 'successful');

        }

    }

    public function PatientBalanceManagement()
    {

        $Credit = DB::table('patient_accounts')
            ->where('OutstandingStatus', 'PartialBalance')
            ->groupBy('PatientEmail')
            ->selectRaw('sum(Balance) as Balance,  PatientEmail, PatientName, PatientPhone, id, _unique'
            )->get();

        $data = [

            "Page"   => "patients.PatientBalanceStatus",
            "Title"  => "Manage Patient Balance Accounts",
            "Desc"   => "Patient Balance Report",
            "Credit" => $Credit,

        ];

        return view('scrn', $data);
    }

    public function DepleteClientBalance($unique)
    {
        $Credit = DB::table('patient_accounts')
            ->where('OutstandingStatus', 'PartialBalance')
            ->where('_unique', $unique)
            ->get();

        $credit_payment_logs = DB::table('balance_deduction_logs')
            ->where('_unique', $unique)
            ->get();

        $data = [

            "Page"                => "patients.DepleteBalance",
            "Title"               => "Record Balance Depletion For the Selected Patient",
            "Desc"                => "Record Balance Depletion",
            "credit_payment_logs" => $credit_payment_logs,
            "Credit"              => $Credit,

        ];

        return view('scrn', $data);
    }

    public function DepletePatientBalance(Request $request)
    {
        $validated = $this->validate($request, [
            '*' => 'required',
        ]);

        $Credit = DB::table('patient_accounts')
            ->where('_unique', $request->unique)
            ->first();

        $AmountPaid  = $request->AmountPaid;
        $Outstanding = $Credit->Balance - $request->AmountPaid;

        if ($Outstanding <= 0) {

            DB::table('patient_accounts')->where('_unique', $request->unique)->delete();

            DB::table('balance_deduction_logs')
                ->insert([

                    'uuid'         => md5($request->unique),
                    '_unique'      => $request->unique,
                    'AmountUsed'   => $AmountPaid,
                    'Balance'      => 0,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at'   => date('Y-m-d'),
                ]);

            return redirect()->back()->with('status', 'Full Client Balance Depletion Recorded and a permanent log has been created', 'successful');
        } else {

            DB::table('patient_accounts')->where('_unique', $request->unique)->update([

                "Balance" => $Outstanding,

            ]);

            DB::table('balance_deduction_logs')
                ->insert([
                    'uuid'         => md5($request->unique),
                    '_unique'      => $request->unique,
                    'AmountUsed'   => $AmountPaid,
                    'Balance'      => $Outstanding,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at'   => date('Y-m-d'),
                ]);

            return redirect()->back()->with('status', 'Partial  Balance Depletion Recorded and a permanent log has been created', 'successful');

        }

    }

    public function SelectCreditRecoveryTimeFrame(Type $var = null)
    {
        $Creditors = DB::table('credit_payment_logs')->get();

        $data = [

            "Page"      => "creditors.DateRangerCreditRecovery",
            "Title"     => "Select The Credit Recovery General Report's Time Period",
            "Desc"      => "Select time-frame to attach report to",

            "Creditors" => $Creditors,

        ];

        return view('scrn', $data);
    }
    public function AcceptDateRangerCreditRecovery(Request $request)
    {

        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('CreditRecoveryGeneralReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);

    }

    public function CreditRecoveryGeneralReport($FromMonth, $ToMonth, $Year)
    {

        $Reports = DB::table('credit_payment_logs AS L')
            ->where('L.Year', $Year)
            ->where('L.Month', '>=', $FromMonth)
            ->where('L.Month', '<=', $ToMonth)
            ->join('payment_methods AS P', 'P.PaymentID', 'L.PaymentMethod')
            ->groupBy('P.PaymentMethod')
            ->selectRaw('sum(AmountPaid) as Total , L.*,  P.PaymentMethod')
            ->get();

        // dd($Reports);

        $data = [

            "Page"    => "creditors.CreditRecoveryReport",
            "Title"   => "Credit Recovery Report",
            "Desc"    => "Report for the Month " . $FromMonth . " To the Month " . $ToMonth . " in the Year " . $Year,

            "Reports" => $Reports,
            "CRR"     => 'true',

        ];

        return view('scrn', $data);

    }

}
