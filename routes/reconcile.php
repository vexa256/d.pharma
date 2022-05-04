<?php

use App\Http\Controllers\ReconciliationsController;
use Illuminate\Support\Facades\Route;

Route::controller(ReconciliationsController::class)->group(function () {

    Route::any('ReconcileStock', 'ReconcileStock')->name('ReconcileStock');

    Route::any('ExtendDrugValidity', 'ExtendDrugValidity')->name('ExtendDrugValidity');

    Route::any('StockReconciliation', 'StockReconciliation')->name('StockReconciliation');

    Route::any('RecordDisposal', 'RecordDisposal')->name('RecordDisposal');

    Route::post('RecordRefund', 'RecordRefund')->name('RecordRefund');

    Route::get('MgtSoonExpiring', 'MgtSoonExpiring')->name('MgtSoonExpiring');

});