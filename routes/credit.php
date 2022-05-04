<?php

use App\Http\Controllers\CreditorsController;
use Illuminate\Support\Facades\Route;

Route::controller(CreditorsController::class)->group(function () {

    Route::post('EffectCreditPayment', 'EffectCreditPayment')
        ->name('EffectCreditPayment');

    Route::get('RecordPay/{id}', 'RecordPay')->name('RecordPay');

    Route::get('CreditorsReport/{FromMonth}/{ToMonth}/{Year}', 'CreditorsReport')->name('CreditorsReport');

    Route::any('AcceptDateRanger', 'AcceptDateRanger')->name('AcceptDateRanger');

    Route::get('DateRanger', 'DateRanger')->name('DateRanger');

});