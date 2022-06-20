<?php

namespace App\Http\Controllers;

use DB;

class CreditController extends Controller
{

    public function SetCreditors()
    {
        $Counter = DB::table('dispense_logs AS D')
        //->where('D.SID', '!=', 'C.SID')
            ->where('D.CreditStatus', 'true')
            ->count();

        // dd($Counter);

        if ($Counter > 0) {

            $Insert = DB::table('dispense_logs AS D')
            //->where('D.SID', '!=', 'C.SID')
                ->where('D.CreditStatus', 'true')
                ->get();

            foreach ($Insert as $data) {

                $SecondCounter = DB::table('creditors_logs')
                    ->where('CreditCard', $data->CreditCard)
                    ->count();

                if ($SecondCounter == 0) {
                    DB::table('creditors_logs')->Insert([

                        "SID"          => $data->SID,
                        "CreditCard"   => $data->CreditCard,
                        "PID"          => $data->PID,
                        "DID"          => $data->DID,
                        "CreditAmount" => $data->SubTotal,
                        "PaidAmount"   => 00,
                        "CreditStatus" => 'true',
                        "Balance"      => $data->SubTotal,
                        "Month"        => date("m"),
                        "Year"         => date("Y"),
                    ]);
                }

            }
        }

    }

    public function CompleteDebt()
    {
        $CreditCounter = DB::table('creditors_logs')
            ->where('CreditStatus', 'true')
            ->where('Balance', 0)
            ->count();

        if ($CreditCounter > 0) {

            $CreditUpdater = DB::table('creditors_logs')
                ->where('CreditStatus', 'true')
                ->where('Balance', 0)
                ->get();

            foreach ($CreditUpdater as $credit) {
                DB::table('creditors_logs')->where('id', $credit->id)
                    ->update([

                        "CreditStatus" => 'false',

                    ]);

                DB::table('dispense_logs')->where('CreditCard', $credit->CreditCard)
                    ->update([

                        "CreditStatus" => 'false',

                    ]);
            }

        }
    }

    public function RunCreditLogic()
    {
        $this->CompleteDebt();
        $this->SetCreditors();
    }
}
