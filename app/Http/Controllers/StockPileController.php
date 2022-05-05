<?php

namespace App\Http\Controllers;

use App\Charts\SystemCharts;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FormEngine;
use App\Http\Controllers\ProfitAnalysisLogic;
use App\Http\Controllers\SalesReportLogic;
use App\Http\Controllers\StockTrucker;
use DB;
use Illuminate\Http\Request;

class StockPileController extends Controller
{

    public function __construct()
    {

        $SalesReportLogic = new SalesReportLogic;
        $SalesReportLogic->GenerateMonthsAndYear();
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;

        $ProfitAnalysisLogic->RunAnalysis();

        $count = DB::table('drugs AS D')
            ->where('D.QtyAvailable', '<=', 'D.MinimumQty')
            ->count();
        //dd($count);
        /***  **/

        if ($count > 0) {

            $Up = DB::table('drugs AS D')
                ->where('D.QtyAvailable', '<=', 'D.MinimumQty')
                ->select('D.id')
                ->get();

            foreach ($Up as $data) {

                DB::table('drugs')->where('id', $data->id)->update([

                    'WarningQtyStatus' => 'true',

                    /*******
                 *
                 */
                ]);

            }

        }

        $StockTrucker = new StockTrucker;

        $StockTrucker->CheckLowQtyStock();

        $StockTrucker->LowQtyReversal();

        $Counter = DB::table('stock_piles')->where('ActiveStatus', 'true')
            ->where('StockQty', '<', 1)->count();

        if ($Counter > 0) {

            $Update = DB::table('stock_piles')->where('ActiveStatus', 'true')
                ->where('StockQty', '<', 1)->get();

            foreach ($Update as $data) {
                DB::table('stock_piles')->where('id', $data->id)->update([

                    'ActiveStatus' => 'false',
                ]);
            }
        }

    }

    public function MgtStockPiles($id)
    {
        $FormEngine = new FormEngine;

        $rem = [
            'VID', 'DCID', 'Barcode', 'analyzed', "MeasurementUnits", 'DID', 'WarningQtyStatus', 'ExpiryStatus', 'ProfitMargin', 'LossMargin', 'id', 'uuid', 'created_at', 'updated_at', 'StockID', 'ActiveStatus', 'StockTag', 'MonthsToExpiry', 'Currency'];

        $StockTag = strtoupper(\Str::random(3) . '' . sprintf("%01d", mt_rand(1, 999)));

        $Categories = DB::table('drug_categories')->get();

        $Vendors = DB::table('drugs_vendors')->get();

        $Currencies = DB::table('currencies')->get();

        $Units = DB::table('drug_units')->get();

        $Drugs = DB::table('drugs')->where('id', $id)->first();

        $Stock = DB::table('stock_piles AS B')
            ->where('B.ActiveStatus', 'true')
            ->join('drugs AS DS', 'DS.DID', '=', 'B.DID')
            ->join('drug_categories AS D', 'D.DCID', '=', 'DS.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DS.MeasurementUnits')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'B.VID')
            ->where('DS.id', $id)
            ->select('B.*', 'B.id AS BautoID', 'DS.*', 'DS.DrugName', 'U.Unit AS Dunit', 'V.Name AS VendorName', 'D.CategoryName AS CatName')
            ->get();

        $a = $Stock;
        $StockTags = $a->pluck('StockTag');
        $Qty = $a->pluck('StockQty');

        $chart = new SystemCharts;
        $chart->labels($StockTags);
        $chart->dataset($Drugs->DrugName . ' stockpiles statistics', 'bar', $Qty)
            ->backgroundColor('purple');
        $chart->height(300);
        $chart->loaderColor('red');

        $data = [

            "Page" => "stock.MgtStock",
            "Title" => "Manage the selected drug  stockpiles",
            "Desc" => "Only valid stockpiles are shown",
            "Stock" => $Stock,
            "Vendors" => $Vendors,
            "Currencies" => $Currencies,
            "DrugCategories" => $Categories,
            "StockTag" => $StockTag,
            "Units" => $Units,
            "Drugs" => $Drugs,
            "Total" => $Stock->sum('StockQty'),
            "rem" => $rem,
            "chart" => $chart,
            "Form" => $FormEngine->Form('stock_piles'),

        ];

        return view('scrn', $data);
    }

    public function LowInStockPile(Type $var = null)
    {
        $Drugs = DB::table('stock_piles AS B')
            ->where('B.ActiveStatus', 'true')
            ->join('drugs AS DS', 'DS.DID', '=', 'B.DID')
            ->where('DS.WarningQtyStatus', 'true')
            ->join('drug_categories AS D', 'D.DCID', '=', 'DS.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DS.MeasurementUnits')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'B.VID')

            ->select('B.*', 'DS.QtyAvailable', 'DS.DrugName', 'DS.DrugDescription', 'U.Unit AS Dunit', 'V.Name AS VendorName', 'D.CategoryName AS CatName')
            ->get()->unique('DrugName');

        $data = [

            "Page" => "drugs.LowInStock",
            "Title" => "Track drugs that need restocking",
            "Desc" => "Only drugs below their MIN QTY are shown",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }

    public function SelectDrugStockPile(Type $var = null)
    {
        $Drugs = DB::table('drugs')->get();

        $data = [

            "Page" => "stock.SelectDrug",
            "Title" => "Select a drug to add a stockpile to",
            "Desc" => "Drug selection",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }

    public function DrugToStockSelected(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $id = $request->id;

        return redirect()->route('MgtStockPiles', ['id' => $id]);

    }

    public function MgtDrugInventory(Type $var = null)
    {

        $Drugs = DB::table('stock_piles AS B')
            ->where('B.ActiveStatus', 'true')
            ->join('drugs AS DS', 'DS.DID', '=', 'B.DID')
            ->where('DS.StockType', 'drug')
            ->join('drug_categories AS D', 'D.DCID', '=', 'DS.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DS.MeasurementUnits')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'B.VID')
            ->select('B.*', 'DS.DrugName', 'DS.QtyAvailable', 'DS.DrugDescription', 'U.Unit AS Dunit', 'V.Name AS VendorName', 'D.CategoryName AS CatName')
        //->groupBy('B.DID')
            ->get()->unique('DrugName');

        $data = [

            "Page" => "inventory.DrugInventoryReport",
            "Title" => "General Drug Inventory Report Generated on " . date('F j, Y'),
            "Desc" => "Inventory Reports",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }

    public function MgtConsInventory(Type $var = null)
    {

        $Drugs = DB::table('stock_piles AS B')
            ->where('B.ActiveStatus', 'true')
            ->join('drugs AS DS', 'DS.DID', '=', 'B.DID')
            ->where('DS.StockType', '!=', 'drug')
            ->join('drug_categories AS D', 'D.DCID', '=', 'DS.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DS.MeasurementUnits')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'B.VID')
            ->select('B.*', 'DS.DrugName', 'DS.QtyAvailable', 'DS.DrugDescription', 'U.Unit AS Dunit', 'V.Name AS VendorName', 'D.CategoryName AS CatName')
        //->groupBy('B.DID')
            ->get()->unique('DrugName');

        $data = [

            "Page" => "inventory.ConsInventoryReport",
            "Title" => "General Consumable's Inventory Report Generated on " . date('F j, Y'),
            "Desc" => "Inventory Reports",
            "Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }
}