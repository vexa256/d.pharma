<?php

use App\Http\Controllers\DispenseDrugsController;
use App\Http\Controllers\DrugStoreController;
use App\Http\Controllers\ExistingPatientProcessPaymentController;
use App\Http\Controllers\NotifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('PackagePatientExistingProcessPayment', [ExistingPatientProcessPaymentController::class, 'PackagePatientExistingProcessPayment']);

Route::post('ExistingProcessPayment', [ExistingPatientProcessPaymentController::class, 'ExistingProcessPayment']);

Route::get('GetNdaApi', [DrugStoreController::class, 'GetNdaApi']);

Route::get('GeneratePaymentSession', [DispenseDrugsController::class, 'GeneratePaymentSession']);

Route::post('ExistingCartItems', [DispenseDrugsController::class, 'ExistingCartItems']);

Route::post('ProcessDispense', [DispenseDrugsController::class, 'ProcessDispense']);

Route::get('RemoveDrugCartItem/{id}', [DispenseDrugsController::class, 'RemoveDrugCartItem']);

Route::post('GetDispenseCart', [DispenseDrugsController::class, 'GetDispenseCart']);

Route::post('RecordDispenseCache', [DispenseDrugsController::class, 'RecordDispenseCache']);

Route::get('SelectStockPileForDispense/{id}', [DispenseDrugsController::class, 'SelectStockPileForDispense']);

Route::get('GetSoonExpiringDrugs', [NotifyController::class, 'GetSoonExpiringDrugs']);

Route::get('LowInStock', [NotifyController::class, 'LowInStock']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
