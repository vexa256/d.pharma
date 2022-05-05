<?php

use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::controller(StatsController::class)->group(function () {

    Route::get('NotiFicationsCloud', 'NotiFicationsCloud')->name('NotiFicationsCloud');

});