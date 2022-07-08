<?php

use App\Http\Controllers\DispenseDrugsController;
use App\Http\Controllers\PatientHistoryController;
use Illuminate\Support\Facades\Route;

Route::controller(PatientHistoryController::class)->group(function () {

    Route::any('RedirectToOnetimePatientHistory', 'RedirectToOnetimePatientHistory')->name('RedirectToOnetimePatientHistory');

    Route::get('OnetimeSaleHistory/{id}', 'OnetimeSaleHistory')->name('OnetimeSaleHistory');

    Route::get('SelectPatientHistory', 'SelectPatientHistory')->name('SelectPatientHistory');

    Route::post('AcceptPatientHistorySelection', 'AcceptPatientHistorySelection')->name('AcceptPatientHistorySelection');

    Route::get('PatientDispenseHistoryReport/{id}', 'PatientDispenseHistoryReport')->name('PatientDispenseHistoryReport');

});

Route::controller(DispenseDrugsController::class)->group(function () {

    Route::get('ExistingSelectPaymentMethod', 'ExistingSelectPaymentMethod')->name('ExistingSelectPaymentMethod');

    Route::any('AcceptPatientSelection', 'AcceptPatientSelection')->name('AcceptPatientSelection');

    Route::get('DispenseDrugsToExistingPatient/{id}', 'DispenseDrugsToExistingPatient')->name('DispenseDrugsToExistingPatient');

    Route::get('SelectExistingPatient', 'SelectExistingPatient')->name('SelectExistingPatient');

    Route::get('DispenseDrugs', 'DispenseDrugs')->name('DispenseDrugs');

});
