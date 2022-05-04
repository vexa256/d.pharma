<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::controller(InventoryController::class)->group(function () {

    Route::post('VendorContractUpdate', 'VendorContractUpdate')->name('VendorContractUpdate');

    Route::get('MgtDrugUnits', 'MgtDrugUnits')->name('MgtDrugUnits');

    Route::get('VendorContractValidity', 'VendorContractValidity')
        ->name('VendorContractValidity');
    Route::get('MgtDrugVendors', 'MgtDrugVendors')->name('MgtDrugVendors');

    Route::get('MgtDrugCats', 'MgtDrugCats')->name('MgtDrugCats');

});