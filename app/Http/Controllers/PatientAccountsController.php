<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PatientAccountsController extends Controller
{


    public function __construct()
    {
        $A_counter = DB::table('patient_accounts')
        ->where('_unique', 'NULL')
        ->orWhere('_unique', NULL)
        ->orWhere('_unique', ' ')
        ->count();

        if ($A_counter > 0) {

            $Emails = DB::table('patient_accounts')
             ->where('_unique', 'NULL')
            ->orWhere('_unique', NULL)
            ->orWhere('_unique', ' ')->get();

            foreach ($Emails as $data) {

                DB::table('patient_accounts')->where('id', $data->id)->update([

                    "_unique" => md5(\Hash::make(uniqid()))


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

            "Page" => "patients.PatientCredit",
            "Title" => "Manage Patient Credit",
            "Desc" => "Patient Credit Report",
            "Credit" => $Credit,


        ];

        return view('scrn', $data);
    }

    public function ClearDebtNow($unique)
    {
        $Credit= DB::table('patient_accounts')
        ->where('OutstandingStatus', 'PartialCredit')
        ->where('_unique', $unique)
        ->get();



        $credit_payment_logs = DB::table('credit_payment_logs')
        ->where('_unique', $unique)
        ->get();

        $data = [

            "Page" => "patients.ClearDebt",
            "Title" => "Record credit Payment For the Selected Patient",
            "Desc" => "Record credit Payment",
            "credit_payment_logs" => $credit_payment_logs,
            "Credit" => $Credit,


        ];

        return view('scrn', $data);
    }


    public function RecordDebtPay(Request $request)
    {
        $validated = $this->validate($request, [
            '*' => 'required',
        ]);

        $Credit= DB::table('patient_accounts')
        ->where('_unique', $request->unique)
        ->first();


        $AmountPaid = $request->AmountPaid;
        $Outstanding = $Credit->Outstanding - $request->AmountPaid;

        if ($Outstanding <= 0) {

            DB::table('patient_accounts')->where('_unique', $request->unique)->delete();

            DB::table('credit_payment_logs')
            ->insert([

                    'uuid' => md5($request->unique),
                    '_unique' => $request->unique,
                    'AmountPaid' => $AmountPaid,
                    'Outstanding' => 0,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at' => date('Y-m-d')
            ]);

            return redirect()->back()->with('status', 'Full Credit Payment Recorded and a permanent log has been created' ,'successful');
        }else{

            DB::table('patient_accounts')->where('_unique', $request->unique)->update([

                "Outstanding" => $Outstanding,

            ]);


            DB::table('credit_payment_logs')
            ->insert([
                    'uuid' => md5($request->unique),
                    '_unique' => $request->unique,
                    'AmountPaid' => $AmountPaid,
                    'Outstanding' => $Outstanding,
                    'RegisteredBy' => \Auth::user()->name,
                    'created_at' => date('Y-m-d')
            ]);


            return redirect()->back()->with('status', 'Partial Credit Payment Recorded and a permanent log has been created' ,'successful');

        }

    }



}