<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProcessFixesController;
use DB;

//use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
    }

    public function GetSoonExpiringDrugs()
    {
        $Expiring = DB::table('drugs')->where('DrugExpiryStatus', 'Soon Expiring')
            ->count();

        return response()->json([

            "status"   => "200",
            "Expiring" => $Expiring,

        ]);
    }

    public function LowInStock()
    {
        $LockInStockDrugs = DB::table('drugs')->where('WarningQtyStatus', 'true')
            ->count();

        return response()->json([

            "status"           => "200",
            "LockInStockDrugs" => $LockInStockDrugs,

        ]);
    }
}
