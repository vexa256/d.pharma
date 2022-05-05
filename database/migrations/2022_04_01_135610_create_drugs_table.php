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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('DID')->unique();
            $table->string('DrugName')->unique();
            $table->string('GenericName')->nullable();
            $table->string('MeasurementUnits')->nullable();
            $table->string('WarningQtyStatus')->default('false');
            $table->string('ActiveStatus')->default('true');
            $table->string('StockType')->default('drug');
            $table->bigInteger('MinimumQty')->nullable();
            $table->bigInteger('UnitSellingPrice');
            $table->bigInteger('UnitBuyingPrice');
            $table->bigInteger('QtyAvailable')->nullable();
            $table->string('DCID')->nullable();
            $table->string('Currency')->default('UGX');
            $table->bigInteger('ProfitMargin')->nullable();
            $table->bigInteger('LossMargin')->nullable();
            //  $table->string('Vendor');
            //$table->string('BatchNumber')->unique();
            //$table->string('StockID')->unique();
            $table->text('DrugDescription');
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
        Schema::dropIfExists('drugs');
    }
};