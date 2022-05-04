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
        Schema::create('drug_refund_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('DID');
            //$table->string('BatchNumber');
            $table->integer('SellingPrice')->nullable();
            $table->integer('BuyingPrice')->nullable();
            $table->integer('LossMargin')->nullable();
            $table->integer('ProfitMargin')->nullable();
            $table->integer('RefundedQty')->nullable();
            //  $table->string('BatchNumber');
            $table->string('BatchNumber')->nullable();
            $table->integer('RecoveredAmount')->nullable();
            $table->string('RefundRegisteredBy')->nullable();
            $table->string('RefundMonth')->nullable();
            $table->string('RefundYear')->nullable();
            $table->string('StockType')->default('drug');
            $table->text('RefundDetails');
            $table->integer('QtyRecovered')->nullable();
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
        Schema::dropIfExists('drug_refund_logs');
    }
};