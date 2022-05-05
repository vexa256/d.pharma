<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {

    Route::get('/', 'VirtualOffice')->name('VirtualOffice');
    Route::post('UpdateAccount', 'UpdateAccount')->name('UpdateAccount');
    Route::any('MgtUserRoles', 'MgtUserRoles')->name('MgtUserRoles');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');