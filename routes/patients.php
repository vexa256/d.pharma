<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientAccountsController;

Route::controller(PatientController::class)->group(function () {

    Route::any('CachePatientID', 'CachePatientID')->name('CachePatientID');

    Route::any('PatientSettings/{id}', 'PatientSettings')->name('PatientSettings');

    Route::get('NokSelectPatients', 'NokSelectPatients')->name('NokSelectPatients');

    Route::any('MgtNextOfKins', 'MgtNextOfKins')->name('MgtNextOfKins');

    Route::get('MgtPatients', 'MgtPatients')->name('MgtPatients');

    Route::get('MgtPaymentMethod', 'MgtPaymentMethod')->name('MgtPaymentMethod');

    Route::get('MgtPatientPackages', 'MgtPatientPackages')->name('MgtPatientPackages');

});


Route::controller(PatientAccountsController::class)->group(function () {


    Route::get('PatientCreditManagement', 'PatientCreditManagement')
    ->name('PatientCreditManagement');

    Route::get('ClearDebtNow/{unique}', 'ClearDebtNow')->name('ClearDebtNow');

    Route::post('RecordDebtPay', 'RecordDebtPay')->name('RecordDebtPay');

});