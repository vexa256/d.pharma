<?php

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::controller(ReportsController::class)->group(function () {

});

Route::controller(ReportsController::class)->group(function () {

    Route::any('DisposalReportAccept', 'DisposalReportAccept')->name('DisposalReportAccept');

    Route::any('DisposalDateRanger', 'DisposalDateRanger')->name('DisposalDateRanger');

    Route::any('RefundReportAccept', 'RefundReportAccept')->name('RefundReportAccept');

    Route::any('StockRefundDateRanger', 'StockRefundDateRanger')->name('StockRefundDateRanger');

    Route::any('PatientPurchaseAnalysis', 'PatientPurchaseAnalysis')->name('PatientPurchaseAnalysis');

    Route::any('PatientPurchaseAccept', 'PatientPurchaseAccept')->name('PatientPurchaseAccept');

    Route::get('PatientPurchaseAnalysisSelect', 'PatientPurchaseAnalysisSelect')->name('PatientPurchaseAnalysisSelect');

    Route::get('StockSalesDateRanger', 'StockSalesDateRanger')->name('StockSalesDateRanger');

    Route::post('StockSalesReportAccept', 'StockSalesReportAccept')->name('StockSalesReportAccept');

    Route::post('GeneralSalesReportAccept', 'GeneralSalesReportAccept')->name('GeneralSalesReportAccept');

    Route::any('GenerateDisposalReport/{FromMonth}/{ToMonth}/{Year}', 'GenerateDisposalReport')->name('GenerateDisposalReport');

    Route::any('StockRefundReport/{FromMonth}/{ToMonth}/{Year}', 'StockRefundReport')->name('StockRefundReport');

    Route::any('GenerateStockSalesReport/{FromMonth}/{ToMonth}/{Year}', 'GenerateStockSalesReport')->name('GenerateStockSalesReport');

    Route::any('GenerateGeneralSalesReport/{FromMonth}/{ToMonth}/{Year}', 'GenerateGeneralSalesReport')->name('GenerateGeneralSalesReport');

    Route::any('GeneralSalesDateRanger', 'GeneralSalesDateRanger')->name('GeneralSalesDateRanger');

});
