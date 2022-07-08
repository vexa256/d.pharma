<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{

    public function SelectPatientHistory()
    {
        $Patients = DB::table('patients')->get();
        $OneTime  = DB::table('dispense_logs')
            ->where('ExistingStatus', 'false')
            ->get();

        // dd($OneTime);
        // $OneTime  = DB::table('dispensary_notes')->get();

        $data = [

            "Page"     => "PatientHistory.SelectPatient",
            "Title"    => "View the dispense history of the selected patient",
            "Desc"     => "Patient dispense history report",
            "Patients" => $Patients,
            "OneTime"  => $OneTime->unique('PatientName'),
        ];

        return view('scrn', $data);
    }

    public function AcceptPatientHistorySelection(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
            // "email" => 'unique:users',
        ]);

        // $id = $request->id;
        return redirect()->route('PatientDispenseHistoryReport', [

            'id' => $request->id,

        ]);

    }

    public function PatientDispenseHistoryReport($id)
    {

        // DispenseHistory.blade.php

        $Patient = DB::table('patients')->where('id', $id)->first();

        $Notes = DB::table('dispensary_notes')
            ->where('PID', $Patient->PID)->get();

        $Report = DB::table('patients AS P')
            ->join('dispense_logs AS D', 'P.PID', 'D.PID')
            ->join('drugs AS S', 'S.DID', 'D.DID')
            ->where('P.PID', $Patient->PID)
            ->select('P.Name', 'D.*', 'S.DrugName')->get();

        $data = [

            "Page"        => "PatientHistory.DispenseHistory",
            "Title"       => "Pharmacy Dispense History For The Patient " . $Patient->Name . ' (Existing Patient)',
            "Desc"        => "Patient dispense history report",
            "Report"      => $Report,
            "Notes"       => $Notes,
            "PatientName" => $Patient->Name,
        ];

        return view('scrn', $data);

    }

    public function RedirectToOnetimePatientHistory(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
            // "email" => 'unique:users',
        ]);

        // dd($request->id);

        // $id = $request->id;
        return redirect()->route('OnetimeSaleHistory', [

            'id' => $request->id,

        ]);
    }

    public function OnetimeSaleHistory($id)
    {

        $Patient = DB::table('dispense_logs')->where('id', $id)->first();

        $Report = DB::table('dispense_logs AS D')
            ->where('D.PatientName', 'like', '%' . $Patient->PatientName . '%')
        // ->where('D.PatentName', $Patient->PatientName)
            ->join('drugs AS S', 'S.DID', 'D.DID')
            ->select('D.*', 'S.DrugName')->get();

        $data = [

            "Page"        => "PatientHistory.OneTimeHistory",
            "Title"       => "Pharmacy Dispense History For The Patient " . $Patient->PatientName . ' (One-time Sale Patient)',
            "Desc"        => "Patient dispense history report",
            "Report"      => $Report,
            // "Notes"       => $Notes,
            "PatientName" => $Patient->PatientName,
        ];

        return view('scrn', $data);

    }

}
