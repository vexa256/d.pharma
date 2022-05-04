<?php

namespace App\Http\Controllers;

use App\Charts\SystemCharts;
use App\Http\Controllers\ProfitAnalysisLogic;
use DB;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function __destruct()
    {
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();
    }

    private function SetValidityMonths()
    {
        $count = DB::table('drugs_vendors')
            ->count();

        if ($count >= 1) {

            $Vendors = DB::table('drugs_vendors')
                ->get();

            foreach ($Vendors as $data) {
                //dd($data->ContractExpiry);
                $this->SetVendorValidity($data->ContractExpiry, $data->uuid);

            }
        }

    }

    private function SetVendorValidity($ContractExpiry, $uuid)
    {
        $ContractValidity = "valid";

        $DifferenceInMonths = null;

        $Now = \Carbon\Carbon::now()->format('Y-m-d');

        $Today = \Carbon\Carbon::parse($Now);

        $Expiry = \Carbon\Carbon::parse($ContractExpiry);

        if ($Expiry->gt($Today)) {

            $diff_in_months = $Today->diffInMonths($Expiry);

            if ($diff_in_months <= 2) {

                $ContractValidity = 'Soon Expiring';
            }

            $Update = DB::table('drugs_vendors')->where('uuid', $uuid)->update([

                'MonthsToContractExpiry' => $diff_in_months,
                'ContractValidity' => $ContractValidity,
            ]);

        } else {

            $Update = DB::table('drugs_vendors')->where('uuid', $uuid)->update([

                'MonthsToContractExpiry' => 0,
                'ContractValidity' => 'Invalid',
            ]);
        }
    }

    public function MgtDrugCats()
    {

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "DCID",

        ];

        $FormEngine = new FormEngine;

        $DrugCategories = DB::table('drug_categories')->get();

        $data = [

            "Page" => "inventory.MgtDrugCat",
            "Title" => "Manage Stock Categories",
            "Desc" => "Configure system wide stock category settings ",
            "Categories" => $DrugCategories,
            "rem" => $rem,
            "Form" => $FormEngine->Form('drug_categories'),

        ];

        return view('scrn', $data);

    }

    public function MgtDrugVendors()
    {
        $this->SetValidityMonths();

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "VID",
            "MonthsToContractExpiry",
            "ContractValidity",

        ];

        $FormEngine = new FormEngine;

        $Vendors = DB::table('drugs_vendors')->get();

        $data = [

            "Page" => "inventory.MgtDrugVendors",
            "Title" => "Manage Stock Vendors",
            "Desc" => "Let's Manage Our Stock Suppliers ",
            "Vendors" => $Vendors,
            "rem" => $rem,
            "Form" => $FormEngine->Form('drugs_vendors'),

        ];

        return view('scrn', $data);
    }

    public function VendorContractValidity()
    {

        $this->SetValidityMonths();

        $chart = new SystemCharts;

        $Vendors = DB::table('drugs_vendors')->get();

        $VendorNames = DB::table('drugs_vendors')
            ->where('ContractValidity', '!=', 'Invalid')
            ->pluck('Name');

        $Months = DB::table('drugs_vendors')
            ->where('ContractValidity', '!=', 'Invalid')
            ->pluck('MonthsToContractExpiry');

        $chart->labels($VendorNames);
        $chart->dataset('Contract Validity In Months', 'bar', $Months)
            ->backgroundColor('purple');
        $chart->height(300);
        $chart->loaderColor('red');

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "uuid",
            "VID",
            "MonthsToContractExpiry",
            "ContractValidity",
            "Phone",
            "Email",
            "Address",
            "ContactPerson",
            "Remarks",
            "Name",

        ];

        $FormEngine = new FormEngine;

        $data = [

            "Page" => "inventory.VendorContracts",
            "Title" => "Vendor Contract Validity Statistics",
            "Desc" => "Track your vendor contract validity",
            "chart" => $chart,
            "Vendors" => $Vendors,
            'rem' => $rem,
            "Form" => $FormEngine->Form('drugs_vendors'),
        ];

        return view('scrn', $data);
    }

    public function MgtDrugUnits(Type $var = null)
    {
        $FormEngine = new FormEngine;
        $rem = [
            'id',
            'created_at',
            'uuid',
            'UnitID',
            'updated_at',
        ];

        $Units = DB::table('drug_units')->get();
        $data = [

            "Page" => "inventory.MgtDrugUnits",
            "Title" => "Create Measurement Units ",
            "Desc" => "These units are used to quantify stock",
            'rem' => $rem,
            'Units' => $Units,
            "Form" => $FormEngine->Form('drug_units'),
        ];

        return view('scrn', $data);
    }

    public function VendorContractUpdate(Request $request)
    {
        $validated = $this->validate($request, [
            '*' => 'required',

        ]);

        $data = DB::table('drugs_vendors')
            ->where('id', $request->id)
            ->first();

        $VendorLogs = DB::table('vendor_logs')
            ->insert([

                "VID" => $data->VID,
                "ContractTerms" => $request->ContractTerms,
                "LastExpiryDate" => $data->ContractExpiry,
                "UpdatedExpiryDate" => $request->ContractExpiry,
                "created_at" => date('Y-m-d'),
                "ContractRenewedBy" => \Auth::user()->name,
                "uuid" => \Hash::make(date('Y-m-d H:I:S')),
            ]);

        DB::table('drugs_vendors')
            ->update(["ContractExpiry" => $request->ContractExpiry,
            ]);

        return redirect()->back()->with('status', 'The vendor contract was updated successfully and a permanent log was created');

    }

}