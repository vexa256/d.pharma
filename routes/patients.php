<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::controller(PatientController::class)->group(function () {

    Route::any('CachePatientID', 'CachePatientID')->name('CachePatientID');

    Route::get('NokSelectPatients', 'NokSelectPatients')->name('NokSelectPatients');

    Route::any('MgtNextOfKins', 'MgtNextOfKins')->name('MgtNextOfKins');

    Route::get('MgtPatients', 'MgtPatients')->name('MgtPatients');

    Route::get('MgtPaymentMethod', 'MgtPaymentMethod')->name('MgtPaymentMethod');

    Route::get('MgtPatientPackages', 'MgtPatientPackages')->name('MgtPatientPackages');

});