<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class PackageAnalysis extends Controller
{
    public function PatientPackageAnalysis(Type $var = null)
    {
        $Analysis = DB::table('dispense_logs AS D')
            ->whereNotNull('D.PID')
            ->join('patients AS P', 'P.PID', 'D.PID')
            ->join('patient_packages AS K', 'K.PackageID', 'D.PackageID')
            ->where('K.BillingStatus', 'Hospital Billable')
            ->groupBy('D.PID')
            ->selectRaw('sum(D.SubTotal) as Total,
            K.PackageAccountValueInLocalCurrency, P.Name, K.PackageName'
            )->get();

        $data = [

            "Page"       => "sys.reports.PackageAnalysisReport",
            "Title"      => "Pharmacy Package Analysis Report",
            "Desc"       => "Only Hospital Billable Packages are Considered",
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
}
