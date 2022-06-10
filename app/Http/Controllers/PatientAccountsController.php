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

    public function PatientCreditManagement(Type $var = null)
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

    public function ClearDebtNow($unique)
    {
        $Credit = DB::table('patient_accounts')
            ->where('OutstandingStatus', 'PartialCredit')
            ->where('_unique', $unique)
            ->get();

        $credit_payment_logs = DB::table('credit_payment_logs')
            ->where('_unique', $unique)
            ->get();

        $data = [

            "Page"                => "patients.ClearDebt",
            "Title"               => "Record credit Payment For the Selected Patient",
            "Desc"                => "Record credit Payment",
            "credit_payment_logs" => $credit_payment_logs,
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

                    'uuid'         => md5($request->unique),
                    '_unique'      => $request->unique,
                    'AmountPaid'   => $AmountPaid,
                    'Outstanding'  => 0,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at'   => date('Y-m-d'),
                ]);

            return redirect()->back()->with('status', 'Full Credit Payment Recorded and a permanent log has been created', 'successful');
        } else {

            DB::table('patient_accounts')->where('_unique', $request->unique)->update([

                "Outstanding" => $Outstanding,

            ]);

            DB::table('credit_payment_logs')
                ->insert([
                    'uuid'         => md5($request->unique),
                    '_unique'      => $request->unique,
                    'AmountPaid'   => $AmountPaid,
                    'Outstanding'  => $Outstanding,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at'   => date('Y-m-d'),
                ]);

            return redirect()->back()->with('status', 'Partial Credit Payment Recorded and a permanent log has been created', 'successful');

        }

    }

    public function PatientBalanceManagement(Type $var = null)
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

}
