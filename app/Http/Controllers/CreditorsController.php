<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreditController;
use DB;
use Illuminate\Http\Request;

class CreditorsController extends Controller
{
    public function __construct()
    {
        $CreditController = new CreditController;
        $CreditController->RunCreditLogic();
    }

    public function __destruct()
    {
        $CreditController = new CreditController;
        $CreditController->RunCreditLogic();
    }

    public function DateRanger()
    {
        $Creditors = DB::table('creditors_logs')->get();

        $data = [

            "Page"      => "creditors.DateRanger",
            "Title"     => "Select Creditor's Report Time Period",
            "Desc"      => "Select time-frame to attach report to",

            "Creditors" => $Creditors,

        ];

        return view('scrn', $data);
    }

    public function AcceptDateRanger(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',

        ]);

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('CreditorsReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);
    }

    public function CreditorsReport($FromMonth, $ToMonth, $Year)
    {

        $Creditors = DB::table('creditors_logs AS C')
            ->where('C.Year', $Year)
            ->where('C.Month', '>=', $FromMonth)
            ->where('C.Month', '<=', $ToMonth)
            ->where('C.CreditStatus', 'true')
            ->join('drugs AS D', 'D.DID', 'C.DID')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('patients AS P', 'P.PID', 'C.PID')
            ->groupBy('P.Name')
            ->selectRaw('sum(CreditAmount) as Total , sum(PaidAmount) as TotalPaid ,  sum(Balance) as BalanceUnpaid , C.*,  U.Unit AS Units , P.Name,P.Phone, P.Email, P.Address, D.DrugName, D.GenericName'
            )->get();

        $data = [

            "Page"      => "creditors.CreditorsReport",
            "Title"     => "Creditors Report and Analytics",
            "Desc"      => "Manage credit records",

            "Creditors" => $Creditors,

        ];

        return view('scrn', $data);
    }

    public function RecordPay($id)
    {

        $GetPID = DB::table('creditors_logs')->where('id', $id)->first();
        $PID    = $GetPID->PID;

        $Patient = DB::table('patients')->where('PID', $PID)->first();

        $Creditors = DB::table('creditors_logs AS C')
            ->where('C.PID', $PID)
            ->where('C.CreditStatus', 'true')
            ->join('drugs AS D', 'D.DID', 'C.DID')
            ->join('dispense_logs AS L', 'L.CreditCard', 'C.CreditCard')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->join('patients AS P', 'P.PID', 'C.PID')
            ->selectRaw('C.*, L.Qty, L.SellingPrice,  U.Unit AS Units , P.Name,P.Phone, P.Email, P.Address, D.DrugName, D.GenericName'
            )->get();

        $data = [

            "Page"      => "creditors.RecordPay",
            "Title"     => "Credit breakdown for the patient " . $Patient->Name,
            "Desc"      => "Record payment from patient",

            "Creditors" => $Creditors,

        ];

        return view('scrn', $data);
    }

    public function EffectCreditPayment(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $Credit = DB::table('creditors_logs')
            ->where('id', $request->id)->first();

        $PaidAmount   = $request->PaidAmount + $Credit->PaidAmount;
        $CreditAmount = $Credit->CreditAmount;
        $Balance      = $CreditAmount - $PaidAmount;

        if ($PaidAmount > $CreditAmount) {
            return redirect()->back()->with('error_a', 'OOPS, You have over paid. The Paid amount is greater than the Credit amount');
        }

        DB::table('creditors_logs')
            ->where('id', $request->id)->update([

            "PaidAmount" => $PaidAmount,
            "Balance"    => $Balance,
        ]);

        return redirect()->back()->with('status', 'The credit payment by the patient has been recorded successfully');
    }

}
