<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ReconciliationsController extends Controller
{

    public function MgtSoonExpiring()
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
            ->where('D.ExpiryStatus', 'Soon Expiring')
            ->where('D.ActiveStatus', 'true')
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
        //->where('DR.StockType', 'drug')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "drugs.MgtSoonExpiring",
            "Title" => "Soon  expiring  stock  ",
            "Desc"  => "Stock with 3 or less months to  expiry ",
            "Drugs" => $Drugs,
            "Soon"  => 'true',
            "rem"   => $rem,

        ];

        return view('scrn', $data);
    }

    public function StockReconciliation()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = ["id", "created_at", "analyzed", "updated_at", "uuid", "StockTag", "StockID", "MonthsToExpiry", "ExpiryStatus", "ActiveStatus", "VID", "DID", "Barcode", "StockQty", "BatchNumber"];

        //$FormEngine = new FormEngine;

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.ExpiryStatus', 'Soon Expiring')
            ->where('D.ActiveStatus', 'true')
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
        //->where('DR.StockType', 'drug')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "drugs.MgtSoonExpiring",
            "Title" => "Soon  expiring  stock  ",
            "Desc"  => "Stock with 3 or less months to  expiry ",
            "Drugs" => $Drugs,
            "Soon"  => 'true',
            "rem"   => $rem,

        ];

        return view('scrn', $data);
    }

    public function RecordRefund(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',

        ]);
        $id = $request->id;

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.id', $id)
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->first();

        $Stock = DB::table('stock_piles')->where('id', $id)->first();

        if ($request->QtyRefundedOrExchangedWithVendor > $Stock->StockQty) {

            return redirect()->back()
                ->with('error_a',
                    'The amount exchanged or refunded by vendor is greater than the stock quantity available on this batch. Enter the correct details and try again.');

        } elseif ($request->QtyRefundedOrExchangedWithVendor < $Stock->StockQty) {

            DB::table('stock_piles')->where('id', $id)->update([

                'StockQty' => $Stock->StockQty - $request->QtyRefundedOrExchangedWithVendor,

            ]);
            $this->RunRefundLog($Drugs, $request);

            return redirect()->back()
                ->with('status',
                    'The selected  stock partial refund was executed successfully and a permanent log was created');

        } elseif ($request->QtyRefundedOrExchangedWithVendor == $Stock->StockQty) {
            DB::table('stock_piles')->where('id', $id)->update([

                'StockQty'     => 0,
                'ActiveStatus' => 'false',

            ]);

            $this->RunRefundLog($Drugs, $request);

            return redirect()->back()
                ->with('status',
                    'The selected  stock refund was executed successfully and a permanent log was created');
        }

    }

    public function RunRefundLog($Drugs, $request)
    {
        $id = $request->id;

        $Profit          = $Drugs->UnitSellingPrice - $Drugs->UnitBuyingPrice;
        $ProjectedProfit = $Profit * $request->AmountOfMoneyRecovered;

        $GetRefund = DB::table('drug_refund_logs')->insert([
            "uuid"               => $Drugs->uuid,
            "SellingPrice"       => $Drugs->UnitSellingPrice,
            "DID"                => $Drugs->DID,
            "VID"                => $Drugs->VID,
            "StockID"            => $Drugs->StockID,
            "BuyingPrice"        => $Drugs->UnitBuyingPrice,
            "LossMargin"         => 'NULL',
            "ProfitMargin"       => 'NULL',
            "RefundedQty"        => $request->QtyRefundedOrExchangedWithVendor,
            // "QtyRecovered" => $Drugs->StockQty,
            "BatchNumber"        => $Drugs->BatchNumber,
            "RecoveredAmount"    => $request->AmountOfMoneyRecovered,
            "RefundDetails"      => $request->RefundDetails,
            "RefundRegisteredBy" => \Auth::user()->name,
            "RefundMonth"        => date('m'),
            "RefundYear"         => date('Y'),
            "created_at"         => date('Y-m-d'),

        ]);
    }

    public function RecordDisposal(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',

        ]);
        $id = $request->id;

        $Drugs = DB::table('stock_piles AS D')
            ->where('D.id', $id)
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->first();

        $Stock = DB::table('stock_piles')->where('id', $id)->first();

        if ($request->QuantityDisposed > $Stock->StockQty) {

            return redirect()->back()
                ->with('error_a',
                    'The disposal quantity is greater than the stock quantity available in this batch. Enter the correct details and try again.');

        } elseif ($request->QuantityDisposed < $Stock->StockQty) {

            DB::table('stock_piles')->where('id', $id)->update([

                'StockQty' => $Stock->StockQty - $request->QuantityDisposed,

            ]);
            $this->CreateDisposalLog($Drugs, $request);

            return redirect()->back()
                ->with('status',
                    'The selected  stock partial disposal was executed successfully and a permanent log was created');

        } elseif ($request->QuantityDisposed == $Stock->StockQty) {
            DB::table('stock_piles')->where('id', $id)->update([

                'StockQty'     => 0,
                'ActiveStatus' => 'false',

            ]);

            $this->CreateDisposalLog($Drugs, $request);

            return redirect()->back()
                ->with('status',
                    'The selected  stock disposal was executed successfully and a permanent log was created');
        }

    }

    public function CreateDisposalLog($Drugs, $request)
    {
        $GetRefund = DB::table('drug_disposal_logs')->insert([
            "uuid"                      => $Drugs->uuid,
            "SellingPrice"              => $Drugs->UnitSellingPrice,
            "DID"                       => $Drugs->DID,
            "VID"                       => $Drugs->VID,
            "StockID"                   => $Drugs->StockID,
            "BuyingPrice"               => $Drugs->UnitBuyingPrice,
            "DisposalLossWithoutProfit" => $request->QuantityDisposed * $Drugs->UnitBuyingPrice,
            "DisposalLossWithProfit"    => $request->QuantityDisposed * $Drugs->UnitSellingPrice,
            //"ProfitMargin" => 'NULL',
            "QuantityDisposed"          => $request->QuantityDisposed,
            // "QtyRecovered" => $Drugs->StockQty,
            "BatchNumber"               => $Drugs->BatchNumber,
            //"RecoveredAmount" => $request->AmountOfMoneyRecovered,
            "DisposalNotes"             => $request->DisposalNotes,
            "DisposalRegisteredBy"      => \Auth::user()->name,
            "DisposedMonth"             => date('m'),
            "DisposedYear"              => date('Y'),
            "created_at"                => date('Y-m-d'),

        ]);
    }

    public function ExtendDrugValidity(Request $request)
    {
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        $id = $request->id;

        $stock = DB::table('stock_piles')->where('id', $id)->first();

        $msg = $stock->ExtendedValidity . " Drug expiry date extended from " . $stock->ExpiryDate . " to " . $request->ExpiryDate . " on " . date("F j, Y") . ".";

        DB::table('stock_piles')->where('id', $id)->update([

            "ExpiryDate"       => $request->ExpiryDate,
            "ExtendedValidity" => $msg,
        ]);

        return redirect()->back()
            ->with('status',
                "The selected stock piles's expiration date was extended successfully");
    }

    public function ReconcileStock()
    {
        // $this->SetDrugMonthsToExpiry();

        $rem = ["id", "created_at", "updated_at", "uuid", "StockTag", "StockID", "MonthsToExpiry", "ExpiryStatus", "ActiveStatus", "VID", "DID", "Barcode", "StockQty", "BatchNumber",
        ];

        //$FormEngine = new FormEngine;

        $Drugs = DB::table('stock_piles AS D')
        // ->where('D.ExpiryStatus', 'Soon Expiring')
            ->where('D.ActiveStatus', 'true')
            ->join('drugs AS DR', 'DR.DID', '=', 'D.DID')
        //->where('DR.StockType', 'drug')
            ->join('drug_categories AS DC', 'DC.DCID', '=', 'DR.DCID')
            ->join('drugs_vendors AS V', 'V.VID', '=', 'D.VID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'DR.MeasurementUnits')
            ->select('D.*', 'D.id AS StID', 'DR.*', 'DC.CategoryName AS CatName', 'U.Unit AS Units', 'V.Name AS VendorName')
            ->get();

        $data = [

            "Page"  => "reconcile.Reconcile",
            "Title" => "Stock Reconciliation Operations",
            "Desc"  => "Stock Reconciliation",
            "Drugs" => $Drugs,
            "Soon"  => 'true',
            "rem"   => $rem,

        ];

        return view('scrn', $data);
    }
}
