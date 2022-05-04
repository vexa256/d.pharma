<?php

use App\Http\Controllers\DispenseDrugsController;
use Illuminate\Support\Facades\Route;

Route::controller(DispenseDrugsController::class)->group(function () {

    Route::get('ExistingSelectPaymentMethod', 'ExistingSelectPaymentMethod')->name('ExistingSelectPaymentMethod');

    Route::any('AcceptPatientSelection', 'AcceptPatientSelection')->name('AcceptPatientSelection');

    Route::get('DispenseDrugsToExistingPatient/{id}', 'DispenseDrugsToExistingPatient')->name('DispenseDrugsToExistingPatient');

    Route::get('SelectExistingPatient', 'SelectExistingPatient')->name('SelectExistingPatient');

    Route::get('DispenseDrugs', 'DispenseDrugs')->name('DispenseDrugs');

});