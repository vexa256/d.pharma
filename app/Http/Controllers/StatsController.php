<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

#use Illuminate\Http\Request;
use DB;

class StatsController extends Controller
{
    public function NotiFicationsCloud(Type $var = null)
    {

        $TotalSales = DB::table('dispense_logs')
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        //->where('CreditStatus', 'false')
            ->get();

        $CreditSales = DB::table('patient_accounts')
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        ->where('OutstandingStatus', 'PartialCredit')
            ->get();


        $DrugsInStock = DB::table('drugs')
            ->where('ActiveStatus', 'true')
            ->where('StockType', 'drug')
            ->count();

        $LowInStock = DB::table('drugs')
            ->where('ActiveStatus', 'true')
            ->where('StockType', 'drug')
            ->where('WarningQtyStatus', 'true')
            ->count();

        $ConsInStock = DB::table('drugs')
            ->where('ActiveStatus', 'true')
            ->where('StockType', '!=', 'drug')
        //->where('WarningQtyStatus', 'true')
            ->count();

        $ConsLowInStock = DB::table('drugs')
            ->where('ActiveStatus', 'true')
            ->where('StockType', '!=', 'drug')
            ->where('WarningQtyStatus', 'true')
            ->count();

        $Patients = DB::table('patients')
            ->count();

        $Vendors = DB::table('drugs_vendors')
            ->where('ActiveStatus', 'true')
            ->count();

        $Expiring = DB::table('stock_piles')
            ->where('ActiveStatus', 'true')
            ->where('ExpiryStatus', 'Soon Expiring')
        //->where('WarningQtyStatus', 'true')
            ->count();

        $Expired = DB::table('stock_piles')
            ->where('ActiveStatus', 'true')
            ->where('ExpiryStatus', 'Invalid')
        //->where('WarningQtyStatus', 'true')
            ->count();

        $VendorsExpiring = DB::table('drugs_vendors')
            ->where('ActiveStatus', 'true')
            ->where('ContractValidity', 'Soon Expiring')
            ->count();

        $Users = DB::table('users')

            ->count();
        $data = [

            "Page" => "stats.Notifications",
            "Title" => "System Notifications Dashboard",
            "Desc" => "Statistics and Notifications Panel",
            "TotalSales" => $TotalSales,
            "CreditSales" => $CreditSales,
            "DrugsInStock" => $DrugsInStock,
            "LowInStock" => $LowInStock,
            "ConsInStock" => $ConsInStock,
            "ConsLowInStock" => $ConsLowInStock,
            "Patients" => $Patients,
            "Vendors" => $Vendors,
            "Expiring" => $Expiring,
            "Expired" => $Expired,
            "VendorsExpiring" => $VendorsExpiring,
            "Users" => $Users,
            //"Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }
}
