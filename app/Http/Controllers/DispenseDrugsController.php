<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CreditController;
use App\Http\Controllers\ProcessFixesController;
use App\Http\Controllers\ProfitAnalysisLogic;
use App\Http\Controllers\StockTrucker;
use DB;
use Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DispenseDrugsController extends Controller
{

    public function __construct()
    {
        if (\Schema::hasColumn('dispense_logs', 'PatientName')) {

        } else {
            \Schema::table('dispense_logs', function ($table) {
                $table->string('PatientName')->nullable();
            });
        }

        if (\Schema::hasColumn('patients', 'IsStaffMember')) {

        } else {

            \Schema::table('patients', function ($table) {
                $table->string('IsStaffMember')->default('false');
                $table->string('StaffRole')->default('false');
            });

        }

        if (\Schema::hasTable('dispensary_notes')) {

        } else {

            \Schema::create('dispensary_notes', function (Blueprint $table) {
                $table->id();
                $table->string('uuid');
                $table->string('PID');
                $table->longText('DispensaryNotes');
                $table->timestamps();
            });

        }

        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

        $A_counter = DB::table('patients')->where('Email', 'NA')->count();

        if ($A_counter > 0) {

            $Emails = DB::table('patients')->where('Email', 'NA')->get();

            foreach ($Emails as $data) {

                DB::table('patients')->where('id', $data->id)->update([

                    "Email" => 'Email@' . uniqid() . '.com',

                ]);
            }

        }

        $A_counter = DB::table('patients')->where('Phone', 'NA')->count();

        if ($A_counter > 0) {

            $Emails = DB::table('patients')->where('Phone', 'NA')->get();

            foreach ($Emails as $data) {

                DB::table('patients')->where('id', $data->id)->update([

                    "Phone"   => '0786190170',
                    "Address" => 'Kampala',

                ]);
            }

        }

        $SalesReportLogic    = new SalesReportLogic;
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();

        $CreditController = new CreditController;
        $CreditController->RunCreditLogic();
    }

    public function __destruct()
    {
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();

        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

    }

    public function DispenseDrugs()
    {

        $Drugs = DB::table('drugs AS D')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->select('D.*', 'U.Unit AS Units')->get();
        $PaymentSessionID = Hash::make(Str::random(40) . date('Y-m-d H:I:S'));

        $payment_methods = DB::table('payment_methods')
            ->where('PaymentMethod', 'not like', '%Insurance%')
            ->where('PaymentMethod', 'not like', '%Credit%')
            ->where('PaymentMethod', 'not like', '%Hospital Billable%')
            ->get();

        // dd($payment_methods);

        $data = [

            "Page"             => "dispense.Dispense",
            "Title"            => "Sell stock ",
            "Desc"             => "Dispense stock items to a patient",
            "wizard"           => "true",
            "Drugs"            => $Drugs,
            "payment_methods"  => $payment_methods,
            "PaymentSessionID" => $PaymentSessionID,

        ];

        return view('scrn', $data);

    }

    public function SelectStockPileForDispense($id)
    {
        $StockPiles = DB::table('drugs AS D')
            ->where('D.id', $id)
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('stock_piles AS S', 'S.DID', 'D.DID')
            ->where('S.ActiveStatus', 'true')
            ->select('D.*', 'S.*', 'U.Unit AS Units')->get();

        $Count = 'false';

        if ($StockPiles->count() > 0) {

            $Count = 'true';
        }

        return response()->json([
            'status'     => 'success',
            'StockPiles' => $StockPiles,
            'Count'      => $Count,
        ]);
    }

    public function RecordDispenseCache(Request $request)
    {

        $validated = $request->validate([
            '*' => 'required',
        ]);

        $Drugs = DB::table('drugs AS D')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('stock_piles AS S', 'S.DID', 'D.DID')
            ->where('S.StockID', $request->StockID)
            ->select('D.*', 'S.*', 'U.Unit AS Units')->first();

        if ($request->QtySelected > $Drugs->StockQty) {
            return response()->json([
                'status'  => 'QtyError',
                'Message' => 'The  stock item quantity entered is greater than the amount available in the selected  stockpile ',
            ]);
        }

        DB::table('payment_sessions')->insert([
            "SID"          => $request->PaymentSessionID,
            "StockID"      => $request->StockID,
            "PatientName"  => $request->PatientName,
            "PatientPhone" => $request->PatientPhone,
            "PatientEmail" => $request->PatientEmail,
            "DrugName"     => $Drugs->DrugName,
            "GenericName"  => $Drugs->GenericName,
            "Units"        => $Drugs->Units,
            "UnitCost"     => $Drugs->UnitSellingPrice,
            "Qty"          => $request->QtySelected,
            "SubTotal"     => $request->QtySelected * $Drugs->UnitSellingPrice,
            "DispensedBy"  => $request->DispensedBy,
            "created_at"   => date('Y-m-d'),
        ]);

        return response()->json([
            'status'  => 'success',
            'Message' => 'Stock Item successfully added to dispense selection',
        ]);

    }

    public function GetDispenseCart(Request $request)
    {
        $CartItems = DB::table('payment_sessions')
            ->where('SID', $request->PaymentSessionID)
            ->get();

        return response()->json([
            'status'    => 'success',
            'CartItems' => $CartItems,
            'Total'     => $CartItems->sum('SubTotal'),
        ]);
    }

    public function RemoveDrugCartItem($id)
    {
        DB::table('payment_sessions')->where('id', $id)->delete();

        return response()->json([
            'status'  => 'success',
            'Message' => "stock item removed from dispense selection successfully",
        ]);
    }

    public function ProcessDispense(Request $request)
    {

        $DocumentType = 'Receipt';
        $CreditStatus = "false";

        $PaymentMethod = $request->PaymentMethod;

        if ($PaymentMethod == 'Credit' || $PaymentMethod == 'credit') {

            $CreditStatus = "true";
            $DocumentType = "Credit Note";

        } elseif ($request->Outstanding > 0) {

            $CreditStatus = "PartialCredit";

        } elseif ($request->Outstanding < 0) {

            $CreditStatus = "PartialBalance";

        }

        $ValidateCounter = DB::table('dispense_logs')->where('SID', $request->PaymentSessionID)->count();

        if ($ValidateCounter > 0) {

            $receipt = DB::table('dispense_logs')
                ->where('SID', $request->PaymentSessionID)->get();

            return response()->json([
                'status'       => 'Item_Already_purchased',
                'Message'      => "Transaction processed successfully, Please print out the receipt",
                "DocumentType" => $DocumentType,
                "receipt"      => $receipt,
                "TotalSum"     => $receipt->sum('SubTotal'),
            ]);

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
                "created_at"        => date('Y-m-d'),

            ]);
        } elseif ($request->Outstanding < 0) {

            DB::table('patient_accounts')->insert([

                "SID"               => $request->PaymentSessionID,
                "uuid"              => md5($request->PaymentSessionID),
                "PatientEmail"      => $request->PatientEmail,
                "PatientName"       => $request->PatientName,
                "PatientPhone"      => $request->PatientPhone,
                "Outstanding"       => 0,
                "Balance"           => $request->Outstanding,
                "OutstandingStatus" => 'PartialBalance',
                "created_at"        => date('Y-m-d'),

            ]);
        }

        foreach ($PaymentSession as $data) {

            $Drugs = DB::table('drugs')->where('DID', $ExtractDID)->first();
            $Batch = DB::table('stock_piles')->where('StockID', $data->StockID)
                ->first();

            if ($data->Qty > $Batch->StockQty) {

                return response()->json([
                    'status'  => 'out_of_stock',
                    'Message' => $data->DrugName . ' is out stock, restock the item or select another',
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
                "DrugName"        => $data->DrugName,
                "DID"             => $ExtractDID,
                "SID"             => $request->PaymentSessionID,
                "StockID"         => $data->StockID,
                "GenericName"     => $data->GenericName,
                "PatientPhone"    => $data->PatientPhone,
                "PatientEmail"    => $data->PatientEmail,
                "PatientName"     => $data->PatientName,
                "PaymentMode"     => $PaymentMethod,
                "Units"           => $data->Units,
                "Month"           => date('m'),
                "Year"            => date('Y'),
                "Qty"             => $data->Qty,
                "SubTotal"        => $data->SubTotal,
                "DispensedBy"     => $data->DispensedBy,
                "SellingPrice"    => $data->UnitCost,
                "ProjectedProfit" => $ProjectedProfit,
                "BatchNumber"     => $BatchNumber,
                "CreditStatus"    => $CreditStatus,

            ]);
        }

        $receipt = DB::table('dispense_logs')
            ->where('SID', $request->PaymentSessionID)->get();

        $this->UpdateStock($receipt);

        return response()->json([
            'status'       => 'success',
            'Message'      => "Transaction processed successfully, Please print out the receipt",
            "DocumentType" => $DocumentType,
            "receipt"      => $receipt,
            "TotalSum"     => $receipt->sum('SubTotal'),
        ]);

    }

    public function GeneratePaymentSession()
    {
        $PaymentSessionID = Hash::make(Str::random(40) . date('Y-m-d H:I:S'));

        return response()->json([
            'status'           => 'success',
            "PaymentSessionID" => $PaymentSessionID,
        ]);
    }

    public function UpdateStock($Stock)
    {

        if ($Stock->count() > 0) {

            foreach ($Stock as $data) {
                $CacheStock = DB::table('stock_piles')
                    ->where('StockID', $data->StockID)
                    ->first();
                $Update = DB::table('stock_piles')
                    ->where('StockID', $data->StockID)
                    ->update([
                        "StockQty" => $CacheStock->StockQty - $data->Qty,

                    ]);
            }

        }

        $StockTrucker = new StockTrucker;

        $StockTrucker->CheckLowQtyStock();

        $StockTrucker->LowQtyReversal();

    }

    public function SelectExistingPatient()
    {
        $Patients = DB::table('patients')->get();

        $data = [

            "Page"     => "dispense.ExistingPatient.SelectPatient",
            "Title"    => "Select Patient To Dispense stock items To",
            "Desc"     => "Patient stock dispensary wizard",
            "Patients" => $Patients,
        ];

        return view('scrn', $data);
    }

    public function AcceptPatientSelection(Request $request)
    {
        return redirect()
            ->route('DispenseDrugsToExistingPatient', ['id' => $request->id]);

    }

    public function DispenseDrugsToExistingPatient(Request $request, $id)
    {

        //dd(request()->getHost());
        $data = DB::table('patients AS P')
            ->where('P.id', $id)
            ->join('patient_packages AS PP', 'PP.PackageID', 'P.PackageID')
            ->select(
                'P.*',
                'PP.PackageID',
                'PP.BillingStatus',
                'PP.PackageName',
                'P.PatientAccount AS PackageValue'
            )->first();

        session(['CurrentPatientID' => $data->PID]);

        $Drugs = DB::table('drugs')->get();

        $Cart = null;
        if ($request->session()->has('CurrentPatientID')) {

            $Cart = DB::table('payment_sessions')->where('SID', $request->session()
                    ->get('CurrentPatientID'))->get();

        } else {
            session(['CurrentPatientID' => $data->PID]);

            $Cart = DB::table('payment_sessions')->where('SID',
                $request->session()->get('CurrentPatientID'))->get();

        }
        $PatientsDetails = DB::table('patient_packages AS PP')
            ->join('patients AS T', 'T.PackageID', 'PP.PackageID')
            ->where('T.id', $id)
            ->select('PP.PackageName', 'PP.BillingStatus', 'T.*')
            ->get();

        $Packages        = DB::table('patient_packages')->get();
        $DispensaryNotes = DB::table('dispensary_notes')
            ->where('PID', $data->PID)->get();

        $StockUpdate = DB::table('drugs AS B')
            ->join('drug_categories AS D', 'D.DCID', '=', 'B.DCID')
            ->join('drug_units AS U', 'U.UnitID', '=', 'B.MeasurementUnits')
            ->select('B.*', 'U.Unit', 'D.CategoryName AS CatName')
            ->get();

        $Stock = DB::table('drugs')->get();

        $rem = [
            'created_at',
            'updated_at',
            'uuid',
            'id',
            'PID',
            'PackageID',
            'Balance',
            'status',
            'Gender',
            'PatientAccount',
        ];

        $data = [

            "Page"             => "dispense.ExistingPatient.DrugCart",
            "Title"            => "Dispense stock items to an existing patient",
            "Desc"             => "Stock dispensary wizard ",
            "Cart"             => $Cart,
            "rem"              => $rem,
            "PID"              => $data->PID,
            "Stock"            => $Stock,
            "Drugs"            => $Drugs,
            "Packages"         => $Packages,
            "DispensaryNotes"  => $DispensaryNotes,
            "existing"         => "true",
            "PatientID"        => $id,
            "PatientsDetails"  => $PatientsDetails,
            "existing"         => "true",
            "Name"             => $data->Name,
            "BillingStatus"    => $data->BillingStatus,
            "PackageName"      => $data->PackageName,
            "PackageID"        => $data->PackageID,
            "PackageValue"     => $data->PackageValue,
            "PaymentSessionID" => $request->session()->get('CurrentPatientID'),
        ];

        //$request->session()->pull('CurrentPatientID');

        return view('scrn', $data);
    }

    public function ExistingCartItems(Request $request)
    {

        $validated = $request->validate([
            '*' => 'required',
        ]);

        $Drugs = DB::table('drugs AS D')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('stock_piles AS S', 'S.DID', 'D.DID')
            ->where('S.StockID', $request->StockID)
            ->select('D.*', 'S.*', 'U.Unit AS Units')->first();

        if ($request->QtySelected > $Drugs->StockQty) {
            return response()->json([
                'status'  => 'QtyError',
                'Message' => 'The  stock item quantity entered is greater than the amount available in the selected  stockpile ',
            ]);
        }

        $Patient = DB::table('patients')
            ->where('PID', $request->PaymentSessionID)->first();

        DB::table('payment_sessions')->insert([
            "SID"          => $request->PaymentSessionID,
            "StockID"      => $request->StockID,
            "PatientName"  => $Patient->Name,
            "PatientPhone" => $Patient->Phone,
            "PatientEmail" => $Patient->Email,
            "DrugName"     => $Drugs->DrugName,
            "GenericName"  => $Drugs->GenericName,
            "Units"        => $Drugs->Units,
            "UnitCost"     => $Drugs->UnitSellingPrice,
            "Qty"          => $request->QtySelected,
            "SubTotal"     => $request->QtySelected * $Drugs->UnitSellingPrice,
            "DispensedBy"  => $request->DispensedBy,
            "created_at"   => date('Y-m-d'),
        ]);

        return response()->json([
            'status'  => 'success',
            'Message' => 'Item successfully added to dispense selection',
        ]);

    }

    public function ExistingSelectPaymentMethod(Request $request)
    {

        if ($request->session()->has('CurrentPatientID')) {

            $Cart = DB::table('payment_sessions')->where('SID', $request->session()
                    ->get('CurrentPatientID'));
        } else {

            return redirect()->route('SelectExistingPatient')
                ->with('error_a', 'OOPS , The session expired, Please re-select the patient to continue');
        }

        $payment_methods = DB::table('payment_methods')
            ->where('PaymentMethod', 'not like', '%Insurance%')
            ->where('PaymentMethod', 'not like', '%Credit%')
            ->where('PaymentMethod', 'not like', '%Hospital Billable%')
            ->get();

        $Cart = DB::table('payment_sessions')->where('SID', $request->session()
                ->get('CurrentPatientID'));

        $PatientData = DB::table('payment_sessions')->where('SID', $request->session()
                ->get('CurrentPatientID'))->first();

        $Patients = DB::table('patients')->get();

        $BillingStatus = DB::table('patients AS P')
            ->join('patient_packages AS C', 'C.PackageID', 'P.PackageID')
            ->where('P.PID', $request->session()
                    ->get('CurrentPatientID'))
            ->select('C.BillingStatus', 'C.PackageName')
            ->first();

        $RecordKey = \Hash::make($random = Str::random(40));

        $data = [

            "Page"             => "dispense.ExistingPatient.SelectPaymentMethod",
            "Title"            => "Dispense stock | Print Receipt | Select Patient",
            "Desc"             => "Stock dispensary wizard",
            "existing"         => "true",
            "ReloadTimer"      => "true",
            "payment_methods"  => $payment_methods,
            "PatientData"      => $PatientData,
            "BillingStatus"    => $BillingStatus->BillingStatus,
            "PackageName"      => $BillingStatus->PackageName,
            "Patients"         => $Patients,
            "RecordKey"        => $RecordKey,
            "PaymentSessionID" => $request->session()
                ->get('CurrentPatientID'),
        ];

        return view('scrn', $data);
    }

}
