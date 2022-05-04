<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \DB::unprepared('CREATE OR REPLACE VIEW GeneralSalesReport AS SELECT sum(`D`.`SubTotal`) as `TotalSales`, `D`.`PaymentMode`, `D`.`Month`, `D`.`Year` from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`PaymentMode`, `D`.`Month`, `D`.`Year`;');

        \DB::unprepared('CREATE OR REPLACE VIEW DrugSalesReport AS select sum(D.SubTotal) as TotalSales, D.DrugName, D.Month, D.Year from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`DrugName`, `D`.`Month`, `D`.`Year`;');

        \DB::unprepared('CREATE OR REPLACE VIEW PatientPurchaseReport AS select sum(D.SubTotal) as TotalSales, D.PatientName from `dispense_logs` as `D` inner join `drugs` as `DR` on `DR`.`DID` = `D`.`DID` inner join `drug_units` as `U` on `U`.`UnitID` = `DR`.`MeasurementUnits` inner join `stock_piles` as `S` on `S`.`StockID` = `D`.`StockID` group by `D`.`PatientName`;');

        \DB::unprepared("CREATE OR REPLACE VIEW ProfitWithoutCreditReport AS select sum(D.ProjectedProfit) as Profit, D.Month, D.Year from `dispense_logs` as `D` where `D`.`CreditStatus` = 'false' group by `D`.`Month`, `D`.`Year`;");

        \DB::unprepared("CREATE OR REPLACE VIEW CreditAnalysis AS select sum(C.Balance) as Credit, sum(D.ProjectedProfit) as ExpectedProfit, sum(C.PaidAmount) as RecoveredAmount, C.Year, D.Month from `dispense_logs` as `D` inner join `creditors_logs` as `C` on `C`.`CreditCard` = `D`.`CreditCard` group by `C`.`Year`, `C`.`Month`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};