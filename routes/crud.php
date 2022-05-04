<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

Route::controller(CrudController::class)->group(function () {

    Route::get('DeleteData/{id}/{TableName}', 'DeleteData')
        ->name('DeleteData');

    Route::post('MassUpdate', 'MassUpdate')->name('MassUpdate');

    Route::post('MassInsert', 'MassInsert')->name('MassInsert');

});
