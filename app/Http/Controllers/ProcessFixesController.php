<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use DB;

class ProcessFixesController extends Controller
{

    public function FixTimestampLossOnDispenseLogs()
    {

        $counter = DB::table('dispense_logs')
            ->whereNull('Month')
            ->count();

        if ($counter > 0) {

            $update = DB::table('dispense_logs')
                ->whereNull('Month')
                ->get();

            foreach ($update as $data) {

                $Month = date('m', strtotime($data->created_at));
                $Year  = date('Y', strtotime($data->created_at));

                DB::table('dispense_logs')->where('id', $data->id)->update([
                    "Month" => $Month,
                    "Year"  => $Year,
                ]);
            }
        }

    }

}
