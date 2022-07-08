<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProcessFixesController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportsController extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
    }

    public function GeneralSalesDateRanger(Type $var = null)
    {

        $Report = DB::table('GeneralSalesReport')->get();
        $data   = [

            "Page"    => "reports.GeneralSales.DateRanger",
            "Title"   => "Select Timeline to Attach the General Sales  Report to",
            "Desc"    => "Generate General Sales Report",
            "Reports" => $Report,

        ];

        return view('scrn', $data);
    }

    public function GeneralSalesReportAccept(Request $request)
    {

        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        $id = $request->id;

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('GenerateGeneralSalesReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);

        // return redirect()->route('general');

    }

    public function GenerateGeneralSalesReport($FromMonth, $ToMonth, $Year)
    {
        $Report = DB::table('GeneralSalesReport')
            ->where('Year', $Year)
            ->where('Month', '>=', $FromMonth)
            ->where('Month', '<=', $ToMonth)
            ->get();

        $data = [

            "Page"      => "reports.GeneralSales.Report",
            "Title"     => "General Sales Report for the Selected Timeline",
            "Desc"      => "Generate General Sales Report (Filtered by timeline)",
            "Reports"   => $Report,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,
            "Year"      => $Year,

        ];

        return view('scrn', $data);

    }

    public function StockSalesDateRanger(Type $var = null)
    {

        $Report = DB::table('DrugSalesReport')

            ->get();
        $data = [

            "Page"    => "reports.StockSales.DateRanger",
            "Title"   => "Select Timeline to Attach the Stock Sales  Report to",
            "Desc"    => "Generate Stock Sales Report",
            "Reports" => $Report,

        ];

        return view('scrn', $data);
    }

    public function StockSalesReportAccept(Request $request)
    {

        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        $id = $request->id;

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('GenerateStockSalesReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);

        //return redirect()->route('general');

    }

    public function GenerateStockSalesReport($FromMonth, $ToMonth, $Year)
    {
        $Report = DB::table('DrugSalesReport')
            ->where('Year', $Year)
            ->where('Month', '>=', $FromMonth)
            ->where('Month', '<=', $ToMonth)
            ->get();
        $data = [

            "Page"      => "reports.StockSales.StockSalesReport",
            "Title"     => "Stock Sales Report for the Selected Timeline",
            "Desc"      => "Generate Stock Sales Report (Filtered by timeline)",
            "Reports"   => $Report,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,
            "Year"      => $Year,

        ];

        return view('scrn', $data);
    }

    public function PatientPurchaseAnalysisSelect(Type $var = null)
    {
        $Counter = DB::table('dispense_logs AS D')
            ->where('D.ExistingStatus', 'true')
            ->count();

        if ($Counter > 0) {
            $Res = DB::table('dispense_logs AS D')
                ->join('patients AS P', 'P.PID', 'D.PID')
                ->where('D.ExistingStatus', 'true')
                ->select('P.Name', 'P.PID')
                ->get();

            foreach ($Res as $rec) {
                DB::table('dispense_logs')->where('PID', $rec->PID)->update([

                    'PatientName' => $rec->Name,
                ]);
            }
        }

        // $Report = DB::table('patients AS P')->get();
        $Report = DB::table('PatientPurchaseReport')->get();
        $data   = [

            "Page"    => "reports.PatientPurchase.Select",
            "Title"   => "Select the Patient whose purchase power analysis is required",
            "Desc"    => "Patient Purchase Analysis",
            "Reports" => $Report,

        ];

        return view('scrn', $data);
    }

    public function PatientPurchaseAccept(Request $request)
    {
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        if (Cache::has('SelectedPatient')) {

            Cache::forget('SelectedPatient');

            Cache::forever('SelectedPatient', $request->Name);

        } else {

            Cache::forever('SelectedPatient', $request->Name);
        }

        return redirect()->route('PatientPurchaseAnalysis');

    }

    public function PatientPurchaseAnalysis()
    {
        $Report = DB::table('PatientPurchaseReport')
            ->where('PatientName', Cache::get('SelectedPatient'))
            ->get();

        $Patient = DB::table('PatientPurchaseReport')
            ->where('PatientName', Cache::get('SelectedPatient'))
            ->first();

        $data = [

            "Page"        => "reports.PatientPurchase.PurchaseReport",
            "Title"       => "Patient Purchasing Power Analysis for the Selected Patient",
            "Desc"        => "Patient Purchase Analysis",
            "Reports"     => $Report,
            "PatientName" => $Patient->PatientName,

        ];

        return view('scrn', $data);
    }

    public function StockRefundDateRanger(Type $var = null)
    {
        $Report = DB::table('drug_refund_logs')->get();
        $data   = [

            "Page"    => "reports.RefundReport.DateRanger",
            "Title"   => "Select Timeline to Attach the Stock Refund/Exchange Report to",
            "Desc"    => "Generate Refund/Exchange Report",
            "Reports" => $Report,

        ];

        return view('scrn', $data);
    }

    public function RefundReportAccept(Request $request)
    {
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        $id = $request->id;

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('StockRefundReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);
    }

    public function StockRefundReport($FromMonth, $ToMonth, $Year)
    {
        $Report = DB::table('drug_refund_logs AS L')
            ->where('L.RefundYear', $Year)
            ->where('L.RefundMonth', '>=', $FromMonth)
            ->where('L.RefundMonth', '<=', $ToMonth)
            ->join('drugs_vendors AS V', 'V.VID', 'L.VID')
            ->join('drugs AS D', 'D.DID', 'L.DID')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->select('L.*', 'D.DrugName', 'V.Name', 'U.Unit AS UnitName')
            ->get();

        //dd($Report);

        $data = [

            "Page"      => "reports.RefundReport.RefundReport",
            "Title"     => "Stock Refund/Exchange Report for the Selected Timeline",
            "Desc"      => "Stock Refund/Exchange Report (Filtered by timeline)",
            "Reports"   => $Report,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,
            "Year"      => $Year,

        ];

        return view('scrn', $data);
    }

    public function DisposalDateRanger(Type $var = null)
    {

        $Report = DB::table('drug_disposal_logs')->get();
        $data   = [

            "Page"    => "reports.DisposalReport.DateRanger",
            "Title"   => "Select Timeline to Attach the Stock Disposal  Report to",
            "Desc"    => "Generate Stock Disposal Report",
            "Reports" => $Report,

        ];

        return view('scrn', $data);

    }

    public function DisposalReportAccept(Request $request)
    {
        $validated = $request->validate([
            '*'     => 'required',
            'files' => 'nullable',
        ]);

        $id = $request->id;

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('GenerateDisposalReport', [

            'FromMonth' => $request->FromMonth,
            'ToMonth'   => $request->ToMonth,
            'Year'      => $request->Year,

        ]);
    }

    public function GenerateDisposalReport($FromMonth, $ToMonth, $Year)
    {
        $Report = DB::table('drug_disposal_logs AS L')
            ->where('L.DisposedYear', $Year)
            ->where('L.DisposedMonth', '>=', $FromMonth)
            ->where('L.DisposedMonth', '<=', $ToMonth)
            ->join('drugs_vendors AS V', 'V.VID', 'L.VID')
            ->join('drugs AS D', 'D.DID', 'L.DID')
            ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
            ->select('L.*', 'D.DrugName', 'V.Name', 'U.Unit AS UnitName')
            ->get();

        //dd($Report);

        $data = [

            "Page"      => "reports.DisposalReport.DisposalReport",
            "Title"     => "Stock Disposal Report for the Selected Timeline",
            "Desc"      => "Stock Disposal Report  (Filtered by timeline)",
            "Reports"   => $Report,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,
            "Year"      => $Year,

        ];

        return view('scrn', $data);
    }

    public function PatientPackageAnalysis(Type $var = null)
    {
        # code...
    }

}
