<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CreditController;
use App\Http\Controllers\DispenseDrugsController;
use DB;
use Hash;
use Illuminate\Http\Request;

class ExistingPatientProcessPaymentController extends Controller
{

    public function __construct()
    {
        $CreditController = new CreditController;
        $CreditController->RunCreditLogic();
    }

    public function ExistingProcessPayment(Request $request)
    {
        $counter = DB::table('dispense_logs')
            ->where('RecordKey', $request->RecordKey)
            ->count();

        if ($counter > 0) {

            return response()->json([
                'status' => 'issued',
                'Message' => "The receipt for this transaction has already been issued.",

            ]);

        }

        $DocumentType = 'Receipt';
        $CreditStatus = "false";

        $PaymentMethod = $request->PaymentMethod;

        if ($PaymentMethod == 'Credit' || $PaymentMethod == 'credit') {

            $CreditStatus = "false";
            $DocumentType = "Credit Note";

        }elseif ($request->Outstanding > 0) {

            $CreditStatus = "PartialCredit";

        }elseif ($request->Outstanding < 0){

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

                "SID" =>$request->PaymentSessionID,
                "uuid" =>md5($request->PaymentSessionID),
                "PatientEmail" =>$request->PatientEmail,
                "PatientName" =>$request->PatientName,
                "PatientPhone" =>$request->PatientPhone,
                "Outstanding" =>$request->Outstanding,
                "Balance" =>0,
                "OutstandingStatus" =>'PartialCredit',

            ]);
        }elseif ($request->Outstanding < 0) {

            DB::table('patient_accounts')->insert([

                "SID" =>$request->PaymentSessionID,
                "uuid" =>md5($request->PaymentSessionID),
                "PatientEmail" =>$request->PatientEmail,
                "Outstanding" =>0,
                // "PatientEmail" =>$request->PatientEmail,
                "PatientName" =>$request->PatientName,
                "PatientPhone" =>$request->PatientPhone,
                "Balance" => $request->Outstanding,
                "OutstandingStatus" =>'PartialBalance',

            ]);
        }

        foreach ($PaymentSession as $data) {

            $Drugs = DB::table('drugs')->where('DID', $ExtractDID)->first();
            $Batch = DB::table('stock_piles')->where('StockID', $data->StockID)
                ->first();

            if ($data->Qty > $Batch->StockQty) {

                return response()->json([
                    'status' => 'out_of_stock',
                    'Message' => $data->DrugName . ' is out stock, restock the drug or select another drug',
                ]);

            }
            $BatchNumber = $Batch->BatchNumber;

            $UnitBuyingPrice = $Drugs->UnitBuyingPrice;
            $UnitSellingPrice = $data->UnitCost;

            $a = $UnitBuyingPrice * $data->Qty;
            $b = $UnitSellingPrice * $data->Qty;

            $ProjectedProfit = $b - $a;

            $PatientData = DB::table('patients')
            ->where('PID',$request->PaymentSessionID )
            ->first();

            DB::table('dispense_logs')->insert([

                "TransactionID" => $TransactionID,
                "RecordKey" => $request->RecordKey,
                "DrugName" => $data->DrugName,
                "DID" => $ExtractDID,
                "PID" => $request->PaymentSessionID,
                "SID" => $request->PaymentSessionID,
                "StockID" => $data->StockID,
                "GenericName" => $data->GenericName,
                "PatientPhone" => $PatientData->Phone,
                "PatientEmail" => $PatientData->Email,
                "PatientName" => $PatientData->Name,
                // "PatientEmail" => $data->PatientEmail,
                "PaymentMode" => $PaymentMethod,
                "Units" => $data->Units,
                "Qty" => $data->Qty,
                "SubTotal" => $data->SubTotal,
                "DispensedBy" => $data->DispensedBy,
                "SellingPrice" => $data->UnitCost,
                "ProjectedProfit" => $ProjectedProfit,
                "BatchNumber" => $BatchNumber,
                "CreditStatus" => $CreditStatus,
                "CreditCard" => Hash::make($request->PaymentSessionID . date('m-d-Y H:i:s.u') . $data->id),
                "ExistingStatus" => "true",

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
            'status' => 'success',
            'Message' => "Transaction processed successfully, Please print out the receipt",
            "DocumentType" => $DocumentType,
            "receipt" => $receipt,
            "TotalSum" => $receipt->sum('SubTotal'),
        ]);

    }
}
