<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfitAnalysisLogic;
use App\Http\Controllers\StockTrucker;
use DB;
use Illuminate\Http\Request;

class CrudController extends Controller
{

    public function __construct()
    {
        $ProfitAnalysisLogic = new ProfitAnalysisLogic;
        $ProfitAnalysisLogic->RunAnalysis();
    }

    public function DeleteData($id, $TableName)
    {

        if ($TableName == 'stock_piles') {

            $counter = DB::table('stock_piles AS S')
                ->where('S.id', $id)
                ->join('dispense_logs AS D', 'D.StockID', 'S.StockId')
                ->count();

            if ($counter > 0) {

                return redirect()->back()->with('status', 'The selected stock piles has drugs that have already been sold to customers. To remove it kindly use the stock reconciliation feature');
            } elseif ($counter == 0) {

                $data = DB::table($TableName)->where('id', $id)->first();
                DB::table('drug_restock_logs')->where('StockID', $data->StockID)->delete();
                DB::table($TableName)->where('id', $id)->delete();

                return redirect()->back()
                    ->with('status',
                        'The selected record was deleted successfully');

            }

        } else {

            DB::table($TableName)->where('id', $id)->delete();

            return redirect()->back()
                ->with('status',
                    'The selected record was deleted successfully');
        }

    }

    public function SaveData($request)
    {

        if ($request->TableName == "patients") {

            $Package = DB::table('patient_packages')
                ->where('PackageID', $request->PackageID)
                ->first();

            DB::table($request->TableName)->insert(
                $request->except([
                    '_token',
                    'TableName',
                    'id',
                ])
            );

            DB::table('patients')->where('uuid', $request->uuid)->update([

                "PatientAccount" => $Package->PackageAccountValueInLocalCurrency,

            ]);

        } else {
            DB::table($request->TableName)->insert(
                $request->except([
                    '_token',
                    'TableName',
                    'id',
                ])
            );
        }

    }

    public function MassInsert(Request $request)
    {
        if ($request->TableName == "payment_methods") {

            $validated = $request->validate([
                '*' => 'required',
                'PaymentMethod' => 'required|unique:payment_methods',

            ]);

            if ($request->PaymentMethod == "Credit" || $request->PaymentMethod == "credit") {

                return redirect()->back()->with('error_a', 'Payment method already in use');

            } else {

                $this->SaveData($request);

                return redirect()->back()->with('status', 'The record was created successfully');

            }

        }
        if ($request->TableName == "drug_categories") {

            $validated = $request->validate([
                '*' => 'required',
                'CategoryName' => 'required|unique:drug_categories',
                'uuid' => 'required|unique:drug_categories',
                'DCID' => 'required|unique:drug_categories',
            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "patients") {

            $validated = $request->validate([
                '*' => 'required',
                'Name' => 'required|unique:patients',
                'Email' => 'required|unique:patients',
                'Phone' => 'required|unique:patients',
                //'Address' => 'required|unique:patients',

                // 'Phone' => 'required|unique:drugs_vendors',

            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "drugs_vendors") {

            $validated = $request->validate([
                '*' => 'required',
                'Name' => 'required|unique:drugs_vendors',
                'VID' => 'required|unique:drugs_vendors',
                'uuid' => 'required|unique:drugs_vendors',
                'Email' => 'required|unique:drugs_vendors',
                'ContactPerson' => 'required|unique:drugs_vendors',
                'Phone' => 'required|unique:drugs_vendors',

            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "stock_piles") {

            $validated = $request->validate([
                '*' => 'required',
                'StockTag' => 'required|unique:stock_piles',
                'StockID' => 'required|unique:stock_piles',

            ]);

            $this->SaveData($request);

            $StockTrucker = new StockTrucker;

            $StockTrucker->CreateDrugRestockLog();

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "drug_batches") {

            $validated = $request->validate([
                '*' => 'required',
                'BatchTag' => 'required|unique:drug_batches',
                'BatchNumber' => 'required|unique:drug_batches',
                'BatchID' => 'required|unique:drug_batches',
                'uuid' => 'required|unique:drug_batches',

            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "drugs") {

            $validated = $request->validate([
                '*' => 'required',
                'DrugName' => 'required|unique:drugs',

            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } elseif ($request->TableName == "drugs_vendors") {

            $validated = $request->validate([
                '*' => 'required',
                'Email' => 'required|unique:drugs_vendors',
                'VID' => 'required|unique:drugs_vendors',
                'uuid' => 'required|unique:drugs_vendors',
                'Phone' => 'required|unique:drugs_vendors',
                'Name' => 'required|unique:drugs_vendors',
            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');

        } else {
            $validated = $request->validate([
                '*' => 'required',
            ]);

            $this->SaveData($request);

            return redirect()->back()->with('status', 'The record was created successfully');
        }

    }

    public function MassUpdate(Request $request)
    {
        $validated = $this->validate($request, [
            '*' => 'required',
        ]);

        if ($request->TableName == 'stock_piles') {

            $StockPiles = DB::table('stock_piles')->where('id', $request->id)->first();

            DB::table($request->TableName)->where('id', $request->id)

                ->update($request->except([
                    '_token',
                    'TableName',
                    'id',
                ]));

            DB::table('drug_restock_logs')
                ->where('StockID', $StockPiles->StockID)
                ->count();

            $StockTrucker = new StockTrucker;

            $StockTrucker->CreateDrugRestockLog();

            return redirect()->back()->with('status', 'The selected record was updated successfully');

        } else {

            DB::table($request->TableName)->where('id', $request->id)

                ->update($request->except([
                    '_token',
                    'TableName',
                    'id',
                ]));

            return redirect()->back()->with('status', 'The selected record was updated successfully');

        }

    }
}