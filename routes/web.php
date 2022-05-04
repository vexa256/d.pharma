<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    require __DIR__ . '/stats.php';
    require __DIR__ . '/reports.php';
    require __DIR__ . '/reconcile.php';
    require __DIR__ . '/credit.php';
    require __DIR__ . '/stock.php';
    require __DIR__ . '/cons.php';
    require __DIR__ . '/inv.php';
    require __DIR__ . '/DrugStore.php';
    require __DIR__ . '/crud.php';
    require __DIR__ . '/default.php';
    require __DIR__ . '/patients.php';
    require __DIR__ . '/dispense.php';

});
require __DIR__ . '/auth.php';