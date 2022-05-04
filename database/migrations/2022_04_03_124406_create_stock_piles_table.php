<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_piles', function (Blueprint $table) {
            $table->id();
            // $table->string('DCID');
            $table->string('StockTag')->unique();
            $table->string('StockID')->unique();
            //$table->string('MeasurementUnits');
            $table->integer('MonthsToExpiry')->nullable();
            $table->text('ExtendedValidity')->nullable();
            $table->string('BatchNumber')->nullable();
            $table->date('ExpiryDate');
            $table->string('ExpiryStatus')->default('valid');
            $table->string('ActiveStatus')->default('true');
            $table->string('analyzed')->default('false')->nullable();
            $table->string('VID');
            $table->string('DID');
            $table->string('uuid');
            // $table->string('WarningQtyStatus')->default('false');
            $table->string('Barcode')->nullable();
            //$table->integer('MinimumQty');
            $table->integer('StockQty');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_piles');
    }
};