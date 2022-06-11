<?php

use App\Http\Controllers\PatientAccountsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::controller(StaffController::class)->group(function () {

    Route::any('AcceptDateSelectionStaff', 'AcceptDateSelectionStaff')
        ->name('AcceptDateSelectionStaff');

    Route::any('StaffStockLog/{PID}/{FromMonth}/{ToMonth}/{Year}', 'StaffStockLog')->name('StaffStockLog');

    Route::any('StaffStockUtilizationReport/{FromMonth}/{ToMonth}/{Year}', 'StaffStockUtilizationReport')->name('StaffStockUtilizationReport');

    Route::any('StaffSelectDate', 'StaffSelectDate')->name('StaffSelectDate');

    Route::any('MgtStaff', 'MgtStaff')->name('MgtStaff');
});
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

    Route::get('PatientBalanceManagement', 'PatientBalanceManagement')
        ->name('PatientBalanceManagement');

    Route::get('PatientCreditManagement', 'PatientCreditManagement')
        ->name('PatientCreditManagement');

    Route::get('DepleteClientBalance/{unique}', 'DepleteClientBalance')->name('DepleteClientBalance');

    Route::get('ClearDebtNow/{unique}', 'ClearDebtNow')->name('ClearDebtNow');

    Route::post('RecordDebtPay', 'RecordDebtPay')->name('RecordDebtPay');

    Route::post('DepletePatientBalance', 'DepletePatientBalance')->name('DepletePatientBalance');

});
