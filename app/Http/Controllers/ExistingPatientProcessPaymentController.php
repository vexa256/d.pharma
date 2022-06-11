<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CreditController;
use App\Http\Controllers\DispenseDrugsController;
use App\Http\Controllers\FormEngine;
use App\Http\Controllers\ProcessFixesController;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ExistingPatientProcessPaymentController extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

        $CreditController = new CreditController;
        $CreditController->RunCreditLogic();
    }

    public function __destruct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
    }

    public function ExistingProcessPayment(Request $request)
    {
        $counter = DB::table('dispense_logs')
            ->where('RecordKey', $request->RecordKey)
            ->count();

        if ($counter > 0) {

            return response()->json([
                'status'  => 'issued',
                'Message' => "The receipt for this transaction has already been issued.",

            ]);

        }

        $DocumentType = 'Receipt';
        $CreditStatus = "false";

        $PaymentMethod = $request->PaymentMethod;

        if ($PaymentMethod == 'Credit' || $PaymentMethod == 'credit') {

            $CreditStatus = "false";
            $DocumentType = " Receipt";

        } elseif ($request->Outstanding > 0) {

            $CreditStatus = "PartialCredit";

        } elseif ($request->Outstanding < 0) {

            $CreditStatus = "PartialBalance";

        }

        $PaymentSession = DB::table('payment_sessions')->where('SID',
            $request->PaymentSessionID)->get();

        $StartExtract = DB::table('payment_sessions')->where('SID',
            $request->PaymentSessionID)->first();

        $ExtractStockID = $StartExtract->StockID;

        $ProcessStockID = DB::table('stock_piles')->where('StockID',
            $ExtractStockID)->first();

        $ExtractDID = $ProcessStockID->DID;

        $unique_one = sprintf("%04d", mt_rand(1, 999999));
        $unique_two = sprintf("%01d", mt_rand(1, 9));

        $TransactionID = $unique_one . '4' . $unique_two;

        if ($request->Outstanding > 0) {

            $CreditStatus = "PartialCredit";

            DB::table('patient_accounts')->insert([

                "SID"               => $request->PaymentSessionID,
                "uuid"              => md5($request->PaymentSessionID),
                "PatientEmail"      => $request->PatientEmail,
                "PatientName"       => $request->PatientName,
                "PatientPhone"      => $request->PatientPhone,
                "Outstanding"       => $request->Outstanding,
                "Balance"           => 0,
                "OutstandingStatus" => 'PartialCredit',

            ]);
        } elseif ($request->Outstanding < 0) {

            DB::table('patient_accounts')->insert([

                "SID"               => $request->PaymentSessionID,
                "uuid"              => md5($request->PaymentSessionID),
                "PatientEmail"      => $request->PatientEmail,
                "Outstanding"       => 0,
                // "PatientEmail" =>$request->PatientEmail,
                "PatientName"       => $request->PatientName,
                "PatientPhone"      => $request->PatientPhone,
                "Balance"           => abs($request->Outstanding),
                "OutstandingStatus" => 'PartialBalance',

            ]);
        }

        foreach ($PaymentSession as $data) {

            $Drugs = DB::table('drugs')->where('DID', $ExtractDID)->first();
            $Batch = DB::table('stock_piles')->where('StockID', $data->StockID)
                ->first();

            if ($data->Qty > $Batch->StockQty) {

                return response()->json([
                    'status'  => 'out_of_stock',
                    'Message' => $data->DrugName . ' is out stock, restock the drug or select another drug',
                ]);

            }
            $BatchNumber = $Batch->BatchNumber;

            $UnitBuyingPrice  = $Drugs->UnitBuyingPrice;
            $UnitSellingPrice = $data->UnitCost;

            $a = $UnitBuyingPrice * $data->Qty;
            $b = $UnitSellingPrice * $data->Qty;

            $ProjectedProfit = $b - $a;

            $PatientData = DB::table('patients')
                ->where('PID', $request->PaymentSessionID)
                ->first();

            DB::table('dispense_logs')->insert([

                "TransactionID"   => $TransactionID,
                "RecordKey"       => $request->RecordKey,
                "DrugName"        => $data->DrugName,
                "Month"           => date('m'),
                "Year"            => date('Y'),
                "DrugName"        => $data->DrugName,
                "DID"             => $ExtractDID,
                "PID"             => $request->PaymentSessionID,
                "SID"             => $request->PaymentSessionID,
                "StockID"         => $data->StockID,
                "GenericName"     => $data->GenericName,
                "PatientPhone"    => $PatientData->Phone,
                "PatientEmail"    => $PatientData->Email,
                "PatientName"     => $PatientData->Name,
                // "PatientEmail" => $data->PatientEmail,
                "PaymentMode"     => $PaymentMethod,
                "Units"           => $data->Units,
                "Qty"             => $data->Qty,
                "SubTotal"        => $data->SubTotal,
                "DispensedBy"     => $data->DispensedBy,
                "SellingPrice"    => $data->UnitCost,
                "ProjectedProfit" => $ProjectedProfit,
                "BatchNumber"     => $BatchNumber,
                "CreditStatus"    => $CreditStatus,
                "CreditCard"      => Hash::make($request->PaymentSessionID . date('m-d-Y H:i:s.u') . $data->id),
                "ExistingStatus"  => "true",

            ]);
        }

        $receipt = DB::table('dispense_logs')
            ->where('SID', $request->PaymentSessionID)
            ->where('RecordKey', $request->RecordKey)
            ->get();

        $DispenseDrugsController = new DispenseDrugsController;
        $DispenseDrugsController->UpdateStock($receipt);

        //$request->session()->forget($request->PaymentSessionID);

        DB::table('payment_sessions')
            ->where('SID', $request->PaymentSessionID)->delete();

        DB::table('patients')->where('PID', $request->PaymentSessionID)
            ->update([
                'PatientAccount' => $request->DEDUCTIBLE_BALANCE,
            ]);

        return response()->json([
            'status'       => 'success',
            'Message'      => "Transaction processed successfully, Please print out the receipt",
            "DocumentType" => $DocumentType,
            "receipt"      => $receipt,
            "TotalSum"     => $receipt->sum('SubTotal'),
        ]);

    }

    public function PackagePatientExistingProcessPayment(Request $request)
    {
        $counter = DB::table('dispense_logs')
            ->where('RecordKey', $request->RecordKey)
            ->count();

        if ($counter > 0) {

            return response()->json([
                'status'  => 'issued',
                'Message' => "The receipt for this transaction has already been issued.",

            ]);

        }

        $DocumentType = 'Receipt';
        $CreditStatus = "false";

        $PaymentMethod = $request->PaymentMethod;

        if ($PaymentMethod == 'Credit' || $PaymentMethod == 'credit') {

            $CreditStatus = "true";
            $DocumentType = " Receipt";
        }

        $PaymentSession = DB::table('payment_sessions')->where('SID',
            $request->PaymentSessionID)->get();

        $StartExtract = DB::table('payment_sessions')->where('SID',
            $request->PaymentSessionID)->first();

        $ExtractStockID = $StartExtract->StockID;

        $ProcessStockID = DB::table('stock_piles')->where('StockID',
            $ExtractStockID)->first();

        $ExtractDID = $ProcessStockID->DID;

        $unique_one = sprintf("%04d", mt_rand(1, 999999));
        $unique_two = sprintf("%01d", mt_rand(1, 9));

        $TransactionID = $unique_one . '4' . $unique_two;

        foreach ($PaymentSession as $data) {

            $Drugs = DB::table('drugs')->where('DID', $ExtractDID)->first();
            $Batch = DB::table('stock_piles')->where('StockID', $data->StockID)
                ->first();

            if ($data->Qty > $Batch->StockQty) {

                return response()->json([
                    'status'  => 'out_of_stock',
                    'Message' => $data->DrugName . ' is out stock, restock the drug or select another drug',
                ]);

            }
            $BatchNumber = $Batch->BatchNumber;

            $UnitBuyingPrice  = $Drugs->UnitBuyingPrice;
            $UnitSellingPrice = $data->UnitCost;

            $a = $UnitBuyingPrice * $data->Qty;
            $b = $UnitSellingPrice * $data->Qty;

            $ProjectedProfit = $b - $a;

            DB::table('dispense_logs')->insert([

                "TransactionID"   => $TransactionID,
                "RecordKey"       => $request->RecordKey,
                "DrugName"        => $data->DrugName,
                "DID"             => $ExtractDID,
                "Month"           => date('m'),
                "Year"            => date('Y'),
                "PID"             => $request->PaymentSessionID,
                "SID"             => $request->PaymentSessionID,
                "StockID"         => $data->StockID,
                "GenericName"     => $data->GenericName,
                "PatientPhone"    => $data->PatientPhone,
                "PatientEmail"    => $data->PatientEmail,
                "PaymentMode"     => $PaymentMethod,
                "Units"           => $data->Units,
                "Qty"             => $data->Qty,
                "SubTotal"        => $data->SubTotal,
                "DispensedBy"     => $data->DispensedBy,
                "SellingPrice"    => $data->UnitCost,
                "ProjectedProfit" => $ProjectedProfit,
                "BatchNumber"     => $BatchNumber,
                "CreditStatus"    => $CreditStatus,
                "CreditCard"      => Hash::make($request->PaymentSessionID . date('m-d-Y H:i:s.u') . $data->id),
                "ExistingStatus"  => "true",

            ]);
        }

        $receipt = DB::table('dispense_logs')
            ->where('SID', $request->PaymentSessionID)
            ->where('RecordKey', $request->RecordKey)
            ->get();

        $DispenseDrugsController = new DispenseDrugsController;
        $DispenseDrugsController->UpdateStock($receipt);

        //$request->session()->forget($request->PaymentSessionID);

        DB::table('payment_sessions')
            ->where('SID', $request->PaymentSessionID)->delete();

        DB::table('patients')->where('PID', $request->PaymentSessionID)
            ->update([
                'PatientAccount' => $request->DEDUCTIBLE_BALANCE,
            ]);

        return response()->json([
            'status'       => 'success',
            'Message'      => "Transaction processed successfully, Please print out the receipt",
            "DocumentType" => $DocumentType,
            "receipt"      => $receipt,
            "TotalSum"     => $receipt->sum('SubTotal'),
        ]);

    }

    public function ReturnDrugUpdateForm($id)
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

            // "Page"           => "drugs.MgtDrugs",
            // "Title"          => "Manage the selected drug settings",
            // "Desc"           => "Single Drug Settings",
            "Drugs"          => $Drugs,
            "rem"            => $rem,
            "MgtDrugsScript" => 'true',
            "Categories"     => $Categories,
            "Units"          => $Units,

            "Form"           => $FormEngine->Form('drugs'),

        ];

        return View::make("dispense.ExistingPatient.StockUpdateSettings", $data)
            ->render();

    }
}
