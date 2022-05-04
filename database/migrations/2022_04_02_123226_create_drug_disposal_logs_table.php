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
        Schema::create('drug_disposal_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('DID');
            $table->string('VID');
            $table->string('StockID');
            //$table->string('BatchNumber');
            $table->integer('SellingPrice')->nullable();
            $table->integer('BuyingPrice')->nullable();
            $table->integer('DisposalLossWithoutProfit')->nullable();
            $table->integer('DisposalLossWithProfit')->nullable();
            //$table->integer('ProfitMargin')->default(0);
            $table->integer('QuantityDisposed')->nullable();
            //  $table->string('BatchNumber');
            $table->string('BatchNumber')->nullable();
            $table->text('DisposalNotes')->nullable();
            // $table->integer('RecoveredAmount')->nullable();
            $table->string('DisposalRegisteredBy')->nullable();
            $table->string('DisposedMonth')->nullable();
            $table->string('DisposedYear')->nullable();
            //$table->integer('QtyDisposed')->nullable();
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
        Schema::dropIfExists('drug_disposal_logs');
    }
};