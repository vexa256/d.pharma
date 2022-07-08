<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfitAnalysisLogic;
use App\Http\Controllers\StockTrucker;
use DB;
use Illuminate\Http\Request;

class DrugStoreController extends Controller
{
    public function __destruct()
    {

        //dd(date('Y-m-d H:i:s'));
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();
    }

    public function __construct()
    {

        //dd(date('Y-m-d H:i:s'));
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();

        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();

        $StockTrucker = new StockTrucker;

        $StockTrucker->CheckLowQtyStock();

        $StockTrucker->LowQtyReversal();
    }
/*** * private function SetDrugMonthsToExpiry() { $count = DB::table('drugs')->where('DrugExpiryStatus', '!=', "Invalid") ->count(); if ($count >= 1) { $Vendors = DB::table('drugs') ->where('DrugExpiryStatus', '!=', "Invalid") ->get(); foreach ($Vendors as $data) { //dd($data->ContractExpiry); $this->SetMonths($data->ExpiryDate, $data->uuid); } } } */

    public function MgtDrugStore(Request $request)
    {

        $rem = ["id", "StockID", "created_at", "MeasurementUnits", "updated_at", "uuid", "DID", "ProfitMargin", "LossMargin", "StockType", "Barcode", "CategoryName", "Currency", "DrugExpiryStatus", "MonthsToExpiry", "Vendor", "WarningQtyStatus", "QtyAvailable", "DCID", 'ActiveStatus'];

        $FormEngine = new FormEngine;

        $Drugs = DB::table('drugs AS B')
            ->join('drug_categories AS D', 'D.DCID', '=', 'B.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'B.MeasurementUnits')
            ->where('B.StockType', 'drug')
            ->select('B.*', 'U.Unit', 'D.CategoryName AS CatName')
            ->get();

        $Categories = DB::table('drug_categories')->get();
        $Units      = DB::table('drug_units')->get();

        $data = [

            "Page"           => "drugs.Drugs",
            "Title"          => "Drug Inventory List, Add  and Manage Drugs",
            "Desc"           => "Drug list settings",
            "Drugs"          => $Drugs,
            "rem"            => $rem,
            "MgtDrugsScript" => 'true',
            "Categories"     => $Categories,
            "Units"          => $Units,

            "Form"           => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function DisposeOffDrug($id)
    {

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.id', $id)
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->first();

        $BuyingPrice  = $Drugs->UnitBuyingPrice;
        $QtyDisposed  = $Drugs->StockQty;
        $DisposalLoss = $BuyingPrice * $QtyDisposed;

        $DisposeDrug = DB::table('drug_disposal_logs')->insert([
            "uuid"                 => $Drugs->uuid,
            "SellingPrice"         => $Drugs->UnitSellingPrice,
            "DID"                  => $Drugs->DID,
            "BuyingPrice"          => $Drugs->UnitBuyingPrice,
            "DisposalLoss"         => $DisposalLoss,
            // "ProfitMargin" => $Drugs->ProfitMargin,
            "DisposedQty"          => $Drugs->StockQty,
            "BatchNumber"          => $Drugs->BatchNumber,
            "DisposalRegisteredBy" => \Auth::user()->name,
            "DisposedMonth"        => date('M'),
            "DisposedYear"         => date('Y'),
            "created_at"           => date('Y-m-d'),

        ]);

        DB::table('stock_piles')->where('id', $id)->update([

            'ActiveStatus' => "false",
        ]);

        return redirect()->back()
            ->with('status',
                'The selected drug stockpile was disposed off successfully and a permanent log was created');

    }

    public function LowInStock()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "DID",
            "ProfitMargin",
            "LossMargin",
            "Barcode",
            "CategoryName",
            "Currency",
            "DrugExpiryStatus",
            "MonthsToExpiry",
            "Vendor",
            "WarningQtyStatus",
            "DrugCategory",
            "QtyAvailable",
            "DrugName",
            "DrugCategory",
            "SellingPrice",
            "BuyingPrice",
            "ProfitMargin",
            "LossMargin",
            "BatchNumber",
            "WarningQtyStatus",
            "ExpiryDate",
            "MinimumQty",
            "QtyAvailable",
            "DrugDescription",

        ];

        $FormEngine = new FormEngine;
        $Drugs      = DB::table('drugs AS D')
            ->where('D.WarningQtyStatus', 'true')
        //->where('D.StockType', 'Consumable')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'D.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'D.MeasurementUnits')
            ->join('stock_piles AS S', 'S.DID', '=', 'D.DID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'S.VID')
            ->select('D.*', 'S.ExpiryStatus', 'S.ExpiryDate', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();
        $data = [

            "Page"  => "drugs.LowInStock",
            "Title" => "Track drugs that need restocking",
            "Desc"  => "Only drugs below their MIN QTY are shown",
            "Drugs" => $Drugs,
            "rem"   => $rem,

            "Form"  => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function RestockDrugs(Request $request)
    {
        $id    = $request->id;
        $Drugs = DB::table('drugs')->where('id', $id)->first();

        $Refill_logs = DB::table('refill_logs')->insert([

            "uuid"             => $Drugs->uuid,
            "DID"              => $Drugs->DID,
            "DrugName"         => $Drugs->DrugName,
            "DrugCategory"     => $Drugs->DrugCategory,
            "SellingPrice"     => $Drugs->SellingPrice,
            "BuyingPrice"      => $Drugs->BuyingPrice,
            "ProfitMargin"     => $Drugs->ProfitMargin,
            "MinimumQty"       => $Drugs->MinimumQty,
            "LossMargin"       => $Drugs->LossMargin,
            //"RecoveredAmount" => $request->RecoveredAmount,
            "ExpiryDate"       => $Drugs->ExpiryDate,
            "BatchNumber"      => $Drugs->BatchNumber,
            "Currency"         => $Drugs->Currency,
            "Vendor"           => $Drugs->Vendor,
            "ExpiryDate"       => $Drugs->ExpiryDate,
            "RefilledBy"       => \Auth::user()->name,
            "QtyBeforeRefill"  => $Drugs->QtyAvailable,
            "QtyAfterRefill"   => $Drugs->QtyAvailable + $request->RefilledQty,
            "RefilledQty"      => $request->RefilledQty,
            "RefillMonth"      => date("M"),
            "RefillYear"       => date("Y"),
            "DrugExpiryStatus" => $Drugs->DrugExpiryStatus,
            "MonthsToExpiry"   => $Drugs->MonthsToExpiry,
            "Barcode"          => $Drugs->Barcode,
            "DrugDescription"  => $Drugs->DrugDescription,
            "created_at"       => date("Y-m-d"),
        ]);

        DB::table('drugs')->where('id', $id)->update([
            'QtyAvailable' => $Drugs->QtyAvailable + $request->RefilledQty,
        ]);

        return redirect()->back()
            ->with('status',
                'The selected drug was restocked successfully and a permanent log was created');

    }

    public function DrugValidity()
    {
        $Drugs = DB::table('drugs AS D')

            ->join('drug_categories AS DC', 'DC.DCID', '=', 'D.DrugCategory')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.Vendor')
            ->select('D.*', 'DC.CategoryName AS CatName', 'DC.MeasurementUnits AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "drugs.DrugValidity",
            "Title" => "Track validity of drugs in stock",
            "Desc"  => "Drug validity is calculated in months ",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }

    public function RestockDrugInventory()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "DID",
            "ProfitMargin",
            "LossMargin",
            "Barcode",
            "CategoryName",
            "Currency",
            "DrugExpiryStatus",
            "MonthsToExpiry",
            "Vendor",
            "WarningQtyStatus",
            "DrugCategory",
            "QtyAvailable",
            "DrugName",
            "DrugCategory",
            "SellingPrice",
            "BuyingPrice",
            "ProfitMargin",
            "LossMargin",
            "BatchNumber",
            "WarningQtyStatus",
            "ExpiryDate",
            "MinimumQty",
            "QtyAvailable",
            "DrugDescription",

        ];

        $FormEngine = new FormEngine;

        $Drugs = DB::table('drugs AS D')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'D.DrugCategory')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.Vendor')
            ->select('D.*', 'DC.CategoryName AS CatName', 'DC.MeasurementUnits AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "drugs.RestockDrugs",
            "Title" => "Lets do some inventory restocking",
            "Desc"  => "Drug inventory restock actions",
            "Drugs" => $Drugs,
            "rem"   => $rem,

            "Form"  => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function SelectAnnualRestockYear()
    {
        $Drugs = DB::table('drug_restock_logs')->select('RestockYear AS Year')->groupBy('Year')
            ->get();

        $data = [

            "Page"  => "drugs.AnnualReportSelect",
            "Title" => "Select the year to attach report to",
            "Desc"  => "Generate annual drug restock report",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);

    }

    public function GenerateAnnualRestock(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $Drugs = DB::table('drug_restock_logs AS D')
            ->where('D.RestockYear', $request->Year)
            ->select('D.*')
            ->get();

        $data = [

            "Page"  => "drugs.AnnualRestockReport",
            "Title" => "Annual restock report for the year " . $request->Year,
            "Desc"  => "Filtered Restock Report",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);

    }

    public function SelectMonthlyRestockYear()
    {
        $Drugs = DB::table('drug_restock_logs')->select('RestockMonth AS Month', 'RestockYear AS Year')
            ->get()->unique('Year', 'Month');

        $data = [

            "Page"  => "drugs.MonthlyReportSelect",
            "Title" => "Select the month and year to attach report to",
            "Desc"  => "Generate monthly drug restock report",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);

    }

    public function GenerateMonthlyRestock(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $counter = DB::table('drug_restock_logs AS D')
            ->where('D.RestockMonth', $request->Month)
            ->where('D.RestockYear', $request->Year)
            ->select('D.*')
            ->count();

        if ($counter < 1) {

            return redirect()->back()->with('error_a', 'The selected query did not return any results, Try again');
        }
        $Drugs = DB::table('drug_restock_logs AS D')
            ->where('D.RestockMonth', $request->Month)
            ->where('D.RestockYear', $request->Year)
            ->select('D.*')
            ->get();

        $data = [

            "Page"  => "drugs.MonthlyRestockReport",
            "Title" => "Monthly restock report for the Month " . $request->Month . ' in the year    ' . $request->Year,
            "Desc"  => "Filtered Restock Report",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);

    }

    public function MgtExpiredDrugs()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "StockTag",
            "StockID",
            "MonthsToExpiry",
            "ExpiryStatus",
            "ActiveStatus",
            "VID",
            "DID",
            "Barcode",
            "StockQty",
            "BatchNumber",

        ];

        //$FormEngine = new FormEngine;

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.ExpiryStatus', 'Invalid')
            ->where('D.ActiveStatus', 'true')
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"    => "drugs.MgtSoonExpiring",
            "Title"   => "Expired  stock items in the inventory",
            "Desc"    => "Expired  stock items",
            "Expired" => "true",
            "Drugs"   => $Drugs,
            "rem"     => $rem,

        ];

        return view('scrn', $data);
    }

    public function GetNdaApi()
    {
        $NDA = \Cache::rememberForever('drug_reserves', function () {
            return DB::table('drug_reserves')->get();
        });
        return response()->json([

            "status" => "success",
            "Drugs"  => $NDA,
        ]);
    }
    public function MgtNDA()
    {
        $NDA = \Cache::rememberForever('drug_reserves', function () {
            return DB::table('drug_reserves')->get();
        });

        $rem = ["id", "StockID", "created_at", "MeasurementUnits", "updated_at", "uuid", "DID", "ProfitMargin", "LossMargin", "Barcode", "CategoryName", "Currency", "DrugExpiryStatus", "MonthsToExpiry", "Vendor", "WarningQtyStatus", "QtyAvailable", "StockType", "DCID"];

        $FormEngine = new FormEngine;

        $Drugs = DB::table('drugs AS B')
            ->join('drug_categories AS D', 'D.DCID', '=', 'B.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'B.MeasurementUnits')
            ->select('B.*', 'U.Unit', 'D.CategoryName AS CatName')
            ->get();

        $Categories = DB::table('drug_categories')->get();
        $Units      = DB::table('drug_units')->get();

        $data = [

            "Page"       => "drugs.MgtNDA",
            "Title"      => "Select drugs to stock from the NDA database",
            "Desc"       => "National Drug Authority Human Medicine Register",
            "Drugs"      => $Drugs,
            "rem"        => $rem,
            "Categories" => $Categories,
            "Units"      => $Units,
            "NDA"        => $NDA,
            "NdaMgt"     => 'true',
            "Form"       => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function AddToDrugList(Request $request)
    {
        $validated = $request->validate([
            '*'        => 'required',
            'DrugName' => 'required|unique:drugs',
            'DID'      => 'required|unique:drugs',

        ]);

        DB::table($request->TableName)->insert(
            $request->except([
                '_token',
                'TableName',
                'id',
            ])
        );

        return redirect()->back()
            ->with('status',
                'The selected record was added to the supported drugs list successfully. To remove it from the supported list. Use the delete option');

    }

    public function NdaServerSideLoader(Request $request)
    {

        return view('users');
    }

    public function DrugSettings($id)
    {

        $rem = ["id", "StockID", "created_at", "MeasurementUnits", "updated_at", "uuid", "DID", "ProfitMargin", "LossMargin", "StockType", "Barcode", "CategoryName", "Currency", "DrugExpiryStatus", "MonthsToExpiry", "Vendor", "WarningQtyStatus", "QtyAvailable", "DCID"];

        $FormEngine = new FormEngine;

        $Drugs = DB::table('drugs AS B')
            ->where('B.id', $id)
            ->join('drug_categories AS D', 'D.DCID', '=', 'B.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'B.MeasurementUnits')
            ->select('B.*', 'U.Unit', 'D.CategoryName AS CatName')
            ->get();

        $Categories = DB::table('drug_categories')->get();
        $Units      = DB::table('drug_units')->get();

        $data = [

            "Page"           => "drugs.MgtDrugs",
            "Title"          => "Manage the selected drug settings",
            "Desc"           => "Single Drug Settings",
            "Drugs"          => $Drugs,
            "rem"            => $rem,
            "MgtDrugsScript" => 'true',
            "Categories"     => $Categories,
            "Units"          => $Units,

            "Form"           => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function PriceList(Type $var = null)
    {
        $PriceList = DB::table('drugs AS D')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('drug_categories AS C', 'C.DCID', 'D.DCID')
            ->select('D.*', 'U.Unit', 'C.CategoryName AS CatName')
            ->get();

        $data = [

            "Page"      => "drugs.PriceList",
            "Title"     => "Inventory Price List",
            "Desc"      => "Price List Settings",
            "PriceList" => $PriceList,

        ];

        return view('scrn', $data);

    }
}
