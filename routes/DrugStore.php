<?php

use App\Http\Controllers\DrugStoreController;
use Illuminate\Support\Facades\Route;

Route::controller(DrugStoreController::class)->group(function () {

    Route::get('DrugSettings/{id}', 'DrugSettings')->name('DrugSettings');

    Route::post('AddToDrugList', 'AddToDrugList')->name('AddToDrugList');

    Route::get('MgtNDA', 'MgtNDA')->name('MgtNDA');

    Route::any('GenerateMonthlyRestock', 'GenerateMonthlyRestock')->name('GenerateMonthlyRestock');

    Route::any('GenerateAnnualRestock', 'GenerateAnnualRestock')->name('GenerateAnnualRestock');

    Route::get('SelectMonthlyRestockYear', 'SelectMonthlyRestockYear')->name('SelectMonthlyRestockYear');

    Route::get('SelectAnnualRestockYear', 'SelectAnnualRestockYear')->name('SelectAnnualRestockYear');

    Route::get('RestockDrugInventory', 'RestockDrugInventory')->name('RestockDrugInventory');

    Route::get('DrugValidity', 'DrugValidity')->name('DrugValidity');

    Route::post('RestockDrugs', 'RestockDrugs')->name('RestockDrugs');

    Route::get('LowInStock', 'LowInStock')->name('LowInStock');

    Route::get('DisposeOffDrug/{id}', 'DisposeOffDrug')->name('DisposeOffDrug');

    Route::get('MgtExpiredDrugs', 'MgtExpiredDrugs')->name('MgtExpiredDrugs');

    Route::get('MgtDrugStore', 'MgtDrugStore')->name('MgtDrugStore');
});