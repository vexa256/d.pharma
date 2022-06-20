<?php

namespace App\Http\Controllers;

use App\Charts\SystemCharts;
use App\Http\Controllers\StockTrucker;
use DB;
use Illuminate\Http\Request;

class ConsumablesController extends Controller
{

    public function __construct()
    {

        $StockTrucker = new StockTrucker;

        $StockTrucker->CheckLowQtyStock();

        $StockTrucker->LowQtyReversal();
    }
    public function MgtCons()
    {

        $Drugs = DB::table('drugs AS B')
            ->where('B.StockType', 'Consumable')
            ->join('drug_categories AS D', 'D.DCID', '=', 'B.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'B.MeasurementUnits')
            ->select('B.*', 'U.Unit', 'D.CategoryName AS CatName')
            ->get();

        $Categories = DB::table('drug_categories')->get();
        $Units      = DB::table('drug_units')->get();

        $data = [

            "Page"       => "consumables.MgtCons",
            "Title"      => "Manage all consumables in the database",
            "Desc"       => "Consumable list settings",
            "Drugs"      => $Drugs,

            "Categories" => $Categories,
            "Units"      => $Units,

        ];

        return view('scrn', $data);
    }

    public function SelectConsStockPile()
    {
        $Drugs = DB::table('drugs')
            ->where('StockType', 'Consumable')
            ->get();

        $data = [

            "Page"  => "consumables.SelectCons",
            "Title" => "Select a consumable to add a stockpile to",
            "Desc"  => "Consumable selection",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }

    public function ConsumableToStockSelected(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $id = $request->id;

        return redirect()->route('MgtConsStockPiles', ['id' => $id]);

    }

    public function MgtConsStockPiles($id)
    {
        $FormEngine = new FormEngine;

        $rem = [
            'VID', 'DCID', 'Barcode', "MeasurementUnits", 'DID', 'WarningQtyStatus', 'ExpiryStatus', 'ProfitMargin', 'LossMargin', 'id', 'uuid', 'created_at', 'updated_at', 'StockID', 'ActiveStatus', 'StockTag', 'MonthsToExpiry', 'Currency'];

        $StockTag = strtoupper(\Str::random(3) . '' . sprintf("%01d", mt_rand(1, 999)));

        $Categories = DB::table('drug_categories')->get();

        $Vendors = DB::table('drugs_vendors')->get();

        $Currencies = DB::table('currencies')->get();

        $Units = DB::table('drug_units')->get();

        $Drugs = DB::table('drugs')->where('id', $id)->first();

        $Stock = DB::table('stock_piles AS B')
            ->where('B.ActiveStatus', 'true')
            ->join('drugs AS DS', 'DS.DID', '=', 'B.DID')
            ->where('DS.StockType', 'Consumable')
            ->join('drug_categories AS D', 'D.DCID', '=', 'DS.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DS.MeasurementUnits')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'B.VID')
            ->where('DS.id', $id)
            ->select('B.*', 'B.id AS BautoID', 'DS.*', 'DS.DrugName', 'U.Unit AS Dunit', 'V.Name AS VendorName', 'D.CategoryName AS CatName')
            ->get();

        $a         = $Stock;
        $StockTags = $a->pluck('StockTag');
        $Qty       = $a->pluck('StockQty');

        $chart = new SystemCharts;
        $chart->labels($StockTags);
        $chart->dataset($Drugs->DrugName . ' stockpiles statistics', 'bar', $Qty)
            ->backgroundColor('purple');
        $chart->height(300);
        $chart->loaderColor('red');

        $data = [

            "Page"           => "consumables.MgtConsStock",
            "Title"          => "Manage consumable's Stockpiles",
            "Desc"           => " Only valid stockpiles are shown",
            "Stock"          => $Stock,
            "Vendors"        => $Vendors,
            "Currencies"     => $Currencies,
            "DrugCategories" => $Categories,
            "StockTag"       => $StockTag,
            "Units"          => $Units,
            "Drugs"          => $Drugs,
            "Total"          => $Stock->sum('StockQty'),
            "rem"            => $rem,
            "chart"          => $chart,
            "Form"           => $FormEngine->Form('stock_piles'),

        ];

        return view('scrn', $data);
    }

    public function ConsLowInStock()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = ["id", "created_at", "updated_at", "uuid", "DID", "ProfitMargin", "LossMargin", "Barcode", "CategoryName", "Currency", "DrugExpiryStatus", "MonthsToExpiry", "Vendor", "WarningQtyStatus", "DrugCategory", "QtyAvailable", "DrugName", "DrugCategory", "SellingPrice", "BuyingPrice", "ProfitMargin", "LossMargin", "BatchNumber", "WarningQtyStatus", "ExpiryDate", "MinimumQty", "QtyAvailable", "DrugDescription"];

        $FormEngine = new FormEngine;

        $Drugs = DB::table('drugs AS D')
            ->where('D.WarningQtyStatus', 'true')
            ->where('D.StockType', 'Consumable')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'D.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'D.MeasurementUnits')
            ->join('stock_piles AS S', 'S.DID', '=', 'D.DID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'S.VID')
            ->select('D.*', 'S.ExpiryStatus', 'S.ExpiryDate', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "consumables.LowInStock",
            "Title" => "Track consumables items that need restocking",
            "Desc"  => "Only consumables below their MIN QTY are shown",
            "Drugs" => $Drugs,
            "rem"   => $rem,

            "Form"  => $FormEngine->Form('drugs'),

        ];

        return view('scrn', $data);
    }

    public function ConsSoonExpiring()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = ["id", "created_at", "updated_at", "uuid", "StockTag", "StockID", "MonthsToExpiry", "ExpiryStatus", "ActiveStatus", "VID", "DID", "Barcode", "StockQty", "BatchNumber",
        ];

        //$FormEngine = new FormEngine;

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.ActiveStatus', 'true')
            ->where('D.ExpiryStatus', 'Soon Expiring')
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->where('DR.StockType', 'Consumable')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "consumables.SoonExpiring",
            "Title" => "Soon  expiring stock items   ",
            "Desc"  => "Stock items with 3 or less months to  expiry ",
            "Drugs" => $Drugs,
            "rem"   => $rem,

        ];

        return view('scrn', $data);
    }

    public function MgtExpiredCons()
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
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->where('DR.StockType', 'Consumable')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"       => "drugs.MgtSoonExpiring",
            "Title"      => "Expired consumables in the inventory",
            "Desc"       => "Invalid consumable stock",
            "Consumable" => "true",
            "Drugs"      => $Drugs,
            "rem"        => $rem,

        ];

        return view('scrn', $data);
    }

}
