<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FormEngine;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

ini_set('memory_limit', '2048M');

class PatientController extends Controller
{
    public function MgtPatientPackages(Type $var = null)
    {
        $Packages = DB::table('patient_packages')->get();

        $rem = [
            'created_at',
            'updated_at',
            'uuid',
            'id',
            'PackageID',
            'status',
            'BillingStatus',
        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page"     => "patients.PatPackages",
            "Title"    => "Manage all the supported patient packages",
            "Desc"     => "Patient Package Settings",
            "Packages" => $Packages,
            "rem"      => $rem,
            "Form"     => $FormEngine->Form('patient_packages'),

        ];

        return view('scrn', $data);

    }

    public function MgtPaymentMethod(Type $var = null)
    {
        $PaymentMethods = DB::table('payment_methods')
            ->where('PaymentMethod', 'not like', '%Insurance%')
            ->where('PaymentMethod', 'not like', '%Credit%')
            ->get();

        $rem = [
            'created_at',
            'updated_at',
            'uuid',
            'id',
            'PaymentID',
            'status',
        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page"           => "patients.MgtPaymentMethod",
            "Title"          => "Manage all the supported patient payment methods",
            "Desc"           => "Patient Payment Settings",
            "PaymentMethods" => $PaymentMethods,
            "rem"            => $rem,
            "Form"           => $FormEngine->Form('payment_methods'),

        ];

        return view('scrn', $data);

    }

    public function MgtPatients(Type $var = null)
    {
        $Patients        = DB::table('patients')->get();
        $Packages        = DB::table('patient_packages')->get();
        $PatientsDetails = Cache::remember('PatientsDetails', 60, function () {
            return DB::table('patient_packages AS PP')
                ->join('patients AS T', 'T.PackageID', 'PP.PackageID')
                ->select('PP.PackageName', 'PP.BillingStatus', 'T.*')
                ->get();
        });

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

        $FormEngine = new FormEngine;

        $data = [

            "Page"            => "patients.PatRecords",
            "Title"           => "Manage all the patients",
            "Desc"            => "Patients Settings",
            "Patients"        => $Patients,
            "Packages"        => $Packages,
            "PatientsDetails" => $PatientsDetails,
            "rem"             => $rem,
            "Form"            => $FormEngine->Form('patients'),

        ];

        return view('scrn', $data);

    }

    public function NokSelectPatients(Type $var = null)
    {
        $Patients = DB::table('patients')->get();

        $data = [

            "Page"     => "patients.SelectNokPatients",
            "Title"    => "Select Patient To Assign Next of Keens to",
            "Desc"     => "Patient Next of Keen Setups",
            "Patients" => $Patients,
        ];

        return view('scrn', $data);
    }

    public function CachePatientID(Request $request)
    {
        Cache::put(\Auth::user()->email, $request->PID, $seconds = 10000);
        return redirect()->route('MgtNextOfKins');

    }

    public function MgtNextOfKins(Request $request)
    {

        if (!Cache::has(\Auth::user()->email)) {

            return redirect()->route('NokSelectPatients')->with('error_a', 'Select patient to assign next of keens to. Cache expired');

        }

        $PID = Cache::get(\Auth::user()->email);

        $Patients = DB::table('patients')->where('PID', $PID)->first();

        $NextOfKins = DB::table('patient_next_of_kin AS N')
            ->join('patients AS P', 'P.PID', 'N.PID')
            ->where('P.PID', $PID)
            ->select('P.PID', 'P.Name AS PatientName', 'N.*')
            ->get();

        $rem = [
            'created_at',
            'updated_at',
            'uuid',
            'id',
            'NID',
            'PID',

        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page"       => "patients.MgtNextOfKins",
            "Title"      => "Manage all the patients next of keens",
            "Desc"       => "Patient Next Of Keens Settings",
            "NextOfKins" => $NextOfKins,
            //"Patients" => $Patients,
            "PID"        => $PID,
            "Name"       => $Patients->Name,
            "rem"        => $rem,
            "Form"       => $FormEngine->Form('patient_next_of_kin'),

        ];

        return view('scrn', $data);

    }

    public function PatientSettings($id)
    {
        $Patients        = DB::table('patients')->get();
        $Packages        = DB::table('patient_packages')->get();
        $PatientsDetails = DB::table('patient_packages AS PP')
            ->join('patients AS T', 'T.PackageID', 'PP.PackageID')
            ->where('T.id', $id)
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
        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page"            => "patients.PatientSettings",
            "Title"           => "Manage all the patients",
            "Desc"            => "Patients Settings",
            "Patients"        => $Patients,
            "Packages"        => $Packages,
            "PatientsDetails" => $PatientsDetails,
            "rem"             => $rem,
            "Form"            => $FormEngine->Form('patients'),

        ];

        return view('scrn', $data);

    }
}
