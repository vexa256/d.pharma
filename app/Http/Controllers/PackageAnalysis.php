<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProcessFixesController;
use DB;

// use Illuminate\Http\Request;

class PackageAnalysis extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
    }

    public function PatientPackageAnalysis(Type $var = null)
    {
        $Analysis = DB::table('dispense_logs AS D')
            ->whereNotNull('D.PID')
            ->join('patients AS P', 'P.PID', 'D.PID')
            ->where('P.IsStaffMember', 'false')
            ->join('patient_packages AS K', 'K.PackageID', 'P.PackageID')
            ->where('K.BillingStatus', 'Hospital Billable')
            ->groupBy('D.PID')
            ->selectRaw('sum(D.SubTotal) as Total,
            K.PackageAccountValueInLocalCurrency, P.Name, K.PackageName'
            )->get();

        $data = [

            "Page"     => "reports.PackageAnalysis.PackageAnalysisReport",
            "Title"    => "Patient Package Utilization Analysis Report",
            "Desc"     => "Only Hospital Billable Packages are Considered",
            "Analysis" => $Analysis,

        ];

        return view('scrn', $data);

    }
}
