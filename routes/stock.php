<?php

use App\Http\Controllers\StockPileController;
use Illuminate\Support\Facades\Route;

Route::controller(StockPileController::class)->group(function () {

    Route::get('MgtDrugInventory', 'MgtDrugInventory')->name('MgtDrugInventory');

    Route::any('DrugToStockSelected', 'DrugToStockSelected')->name('DrugToStockSelected');

    Route::any('SelectDrugStockPile', 'SelectDrugStockPile')->name('SelectDrugStockPile');

    Route::get('LowInStockPile', 'LowInStockPile')->name('LowInStockPile');

    Route::get('MgtStockPiles/{id}', 'MgtStockPiles')->name('MgtStockPiles');

});
