<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Controllers\ProcessFixesController;
use Illuminate\Support\Facades\DB;

class SalesReportLogic extends Controller
{

    public function __construct()
    {

        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();
        /*$report = DB::table('dispense_logs AS D')
    ->join('creditors_logs AS C', 'C.CreditCard', 'D.CreditCard')
    ->groupBy('C.Year', 'C.Month')->selectRaw('sum(C.Balance) as Credit, sum(D.ProjectedProfit) as ExpectedProfit, sum(C.PaidAmount) as RecoveredAmount, C.Year, D.Month')->get();
    dd($report);

     */}
    public function CheckIfViewExists($ViewName)
    {

        $counters = DB::table('information_schema.TABLES')
            ->where('TABLE_NAME', $ViewName)->count();

        return $counters;

    }

    public function CreateReportView($SQL)
    {
        DB::unprepared($SQL);
    }

    public function GenerateMonthsAndYear()
    {
        $counters = DB::table('dispense_logs')
            ->where('Year', null)
            ->where('Month', null)
            ->count();

        //dd($counters);

        if ($counters > 0) {

            $Up = DB::table('dispense_logs')->where('Year', null)
                ->where('Month', null)
                ->get();

            foreach ($Up as $data) {

                DB::table('dispense_logs')->where('id', $data->id)->update([

                    "Year"  => date("Y"),
                    "Month" => date("m"),

                ]);
            }

        }
    }

    public function CreateGeneralSalesReport()
    {
        /* $Drugs = DB::table('dispense_logs AS D')->join('drugs AS DR', 'DR.DID', 'D.DID')->join('drug_units AS U', 'U.UnitID', 'DR.MeasurementUnits')->join('stock_piles AS S', 'S.StockID', 'D.StockID')->groupBy('D.PaymentMode', 'D.Month', 'D.Year')->selectRaw(' sum(D.SubTotal) as TotalSales, D.PaymentMode, D.Month, D.Year')->toSql();*/

        if ($this->CheckIfViewExists('GeneralSalesReport') < 0) {

            $this->CreateReportView("CREATE VIEW GeneralSalesReport AS
            SELECT sum(`D`.`SubTotal`) as `TotalSales`, `D`.`PaymentMode`, `D`.`Month`, `D`.`Year` from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`PaymentMode`, `D`.`Month`, `D`.`Year`;");

        }

    }

    public function CreateDrugSalesReport()
    {
        /*$report = DB::table('dispense_logs AS D')
        ->join('drugs AS DR', 'DR.DID', 'D.DID')
        ->join('drug_units AS U', 'U.UnitID', 'DR.MeasurementUnits')
        ->join('stock_piles AS S', 'S.StockID', 'D.StockID')
        ->groupBy('D.DrugName', 'D.Month', 'D.Year')
        ->selectRaw('sum(D.SubTotal) as TotalSales, D.DrugName, D.Month, D.Year')->toSql();*/

        //dd($report);

        if ($this->CheckIfViewExists('DrugSalesReport') < 0) {

            $this->CreateReportView("CREATE VIEW DrugSalesReport AS select sum(D.SubTotal) as TotalSales, D.DrugName, D.Month, D.Year from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`DrugName`, `D`.`Month`, `D`.`Year`;");
        }
    }

    public function CreatePatientPurchaseReport()
    {
        /* $report = DB::table('dispense_logs AS D')
        ->join('drugs AS DR', 'DR.DID', 'D.DID')
        ->join('drug_units AS U', 'U.UnitID', 'DR.MeasurementUnits')
        ->join('stock_piles AS S', 'S.StockID', 'D.StockID')
        ->groupBy('D.PatientName')
        ->selectRaw('sum(D.SubTotal) as TotalSales, D.PatientName')->toSql();
        dd($report);*/

        if ($this->CheckIfViewExists('PatientPurchaseReport') < 0) {

            $this->CreateReportView("CREATE VIEW PatientPurchaseReport AS select sum(D.SubTotal) as TotalSales, D.PatientName from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`PatientName`;");
        }
    }

    public function CreateProfitWithoutCreditReport()
    {
        /* $report = DB::table('dispense_logs AS D')
        ->where('D.CreditStatus', 'false')
        ->groupBy('D.Month', 'D.Year')
        ->selectRaw('sum(D.SubTotal) as TotalSales, D.Month, D.Year')->toSql();

        dd($report);*/

        if ($this->CheckIfViewExists('ProfitWithoutCreditReport') < 0) {

            $this->CreateReportView("CREATE VIEW ProfitWithoutCreditReport AS select sum(D.ProjectedProfit) as Profit, D.Month, D.Year from `dispense_logs` as `D` where `D`.`CreditStatus` = 'false' group by `D`.`Month`, `D`.`Year`;");

        }
    }

    public function CreateCreditProfit()
    {

    }

    public function CreateViewReports()
    {

    }

}
