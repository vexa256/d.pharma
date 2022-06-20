<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FormEngine;
use DB;
use Illuminate\Http\Request;

class StaffController extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
    }

    public function MgtStaff()
    {
        $Patients = DB::table('patients')
            ->where('IsStaffMember', 'true')->get();

        $Packages = DB::table('patient_packages')
            ->where('PackageName', 'Staff Package')->get();

        $PatientsDetails = DB::table('patient_packages AS PP')
            ->join('patients AS T', 'T.PackageID', 'PP.PackageID')
            ->where('T.IsStaffMember', 'true')
            ->select('PP.PackageName', 'PP.BillingStatus', 'T.*')
            ->get();

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
            'IsStaffMember',
            'Email',
            'Phone',
            'Age',
            'PatientsAge',
            'Address',
            'NextOfKeenName',
            'NextOfKeenGender',
            'NextOfKeenAddress',
            'NextOfKeenPhone',
            'NextOfKeenEmail',
            'NextOfKeenRelationship',
            'KnownAllergies',
            'RelevantMedicalNotes',
            'Gender',
        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page"            => "staff.MgtStaff",
            "Title"           => "Manage all the staff members",
            "Desc"            => "Staff Member Settings",
            "Patients"        => $Patients,
            "Packages"        => $Packages,
            "PatientsDetails" => $PatientsDetails,
            "rem"             => $rem,
            "StaffMember"     => 'true',
            "Form"            => $FormEngine->Form('patients'),

        ];

        return view('scrn', $data);
    }

    public function StaffSelectDate()
    {
        $Reports = DB::table('dispense_logs AS D')
            ->whereNotNull('D.PID')
            ->join('patients AS P', 'P.PID', 'D.PID')
            ->join('patient_packages AS K', 'K.PackageID', 'P.PackageID')
            ->where('P.IsStaffMember', 'true')
            ->select('D.Month', 'D.Year')
            ->get();

        $data = [

            "Page"    => "staff.SelectDate",
            "Title"   => "Select the time frame to attach the staff  stock utilization report to",
            "Desc"    => "Staff members given stock items",
            "Reports" => $Reports,

        ];

        return view('scrn', $data);
    }

    public function AcceptDateSelectionStaff(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $FromMonth = $request->FromMonth;
        $ToMonth   = $request->ToMonth;
        $Year      = $request->Year;

        if ($request->FromMonth > $request->ToMonth) {

            return redirect()->back()->with('error_a', 'The from month must be before the to month');

        } elseif ($request->ToMonth < $request->FromMonth) {

            return redirect()->back()->with('error_a', 'The to month must be after the from month');
        }

        return redirect()->route('StaffStockUtilizationReport', [
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,
            "Year"      => $Year,
        ]);

    }

    public function StaffStockUtilizationReport($FromMonth, $ToMonth, $Year)
    {
        $Analysis = DB::table('dispense_logs AS D')
            ->whereNotNull('D.PID')
            ->where('D.Year', $Year)
            ->where('D.Month', '>=', $FromMonth)
            ->where('D.Month', '<=', $ToMonth)
            ->join('patients AS P', 'P.PID', 'D.PID')
            ->join('patient_packages AS K', 'K.PackageID', 'P.PackageID')
            ->where('P.IsStaffMember', 'true')
            ->groupBy('D.PID')
            ->selectRaw('sum(D.SubTotal) as Total, P.Name, D.PID'
            )->get();

        $data = [

            "Page"      => "staff.StockUtilizationReport",
            "Title"     => "Staff Stock Utilization Report For the selected Timeline",
            "Desc"      => "Staff Stock Utilization Report",
            "Analysis"  => $Analysis,
            "Year"      => $Year,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,

        ];

        return view('scrn', $data);

    }

    public function StaffStockLog($PID, $FromMonth, $ToMonth, $Year)
    {

        $Staff    = DB::table('patients')->where('PID', $PID)->first();
        $Analysis = DB::table('dispense_logs AS D')
            ->whereNotNull('D.PID')
            ->where('D.Year', $Year)
            ->where('D.Month', '>=', $FromMonth)
            ->where('D.Month', '<=', $ToMonth)
            ->join('patients AS P', 'P.PID', 'D.PID')
            ->join('drugs AS DR', 'DR.DID', 'D.DID')
            ->join('drug_units AS U', 'U.UnitID', 'DR.MeasurementUnits')
            ->join('patient_packages AS K', 'K.PackageID', 'P.PackageID')
            ->where('P.IsStaffMember', 'true')
            ->where('P.PID', $PID)
            ->select('D.*', 'U.Unit')
            ->get();

        // dd($Analysis);

        $data = [

            "Page"      => "staff.StaffStockLog",
            "Title"     => "Staff Stock Utilization Log Report for " . $Staff->Name,
            "Desc"      => "Staff Stock Utilization Detailed Log",
            "Details"   => $Analysis,
            "Year"      => $Year,
            "FromMonth" => $FromMonth,
            "ToMonth"   => $ToMonth,

        ];

        return view('scrn', $data);

    }
}
