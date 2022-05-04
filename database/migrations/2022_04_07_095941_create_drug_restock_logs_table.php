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
        Schema::create('drug_restock_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('DID');
            $table->integer('QtyRestocked');
            $table->integer('ProjectedProfit');
            $table->string('StockID');
            $table->string('RestockedBy');
            $table->string('RestockMonth');
            $table->string('RestockYear');
            $table->string('DrugName');
            $table->string('GenericName');
            $table->string('Units')->nullable();
            $table->integer('UnitSellingPrice');
            $table->integer('UnitBuyingPrice');
            $table->string('DrugCategory')->nullable();
            $table->string('Currency');

            //  $table->string('Vendor');
            //$table->string('BatchNumber')->unique();
            //$table->string('StockID')->unique();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_restock_logs');
    }
};