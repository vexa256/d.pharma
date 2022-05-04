<?php

use App\Http\Controllers\ConsumablesController;
use Illuminate\Support\Facades\Route;

Route::controller(ConsumablesController::class)->group(function () {

    Route::get('MgtExpiredCons', 'MgtExpiredCons')->name('MgtExpiredCons');

    Route::get('ConsLowInStock', 'ConsLowInStock')->name('ConsLowInStock');

    Route::get('SelectConsStockPile', 'SelectConsStockPile')
        ->name('SelectConsStockPile');

    Route::any('ConsumableToStockSelected', 'ConsumableToStockSelected')
        ->name('ConsumableToStockSelected');

    Route::get('MgtConsStockPiles/{id}', 'MgtConsStockPiles')->name('MgtConsStockPiles');

    Route::get('ConsSoonExpiring', 'ConsSoonExpiring')->name('ConsSoonExpiring');

    Route::get('MgtCons', 'MgtCons')->name('MgtCons');

});