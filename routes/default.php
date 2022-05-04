<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {

    Route::get('/', 'VirtualOffice')->name('VirtualOffice');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');