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
        Schema::create('profit_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('StockID')->unique();
            $table->string('DID');
            $table->bigInteger('Month');
            $table->bigInteger('Year');
            $table->bigInteger('ProjectedProfit');
            $table->bigInteger('ActualProfit')->nullable()->default(0);
            $table->bigInteger('ActualLoss')->nullable()->default(0);
            $table->bigInteger('CreditLoss')->nullable()->default(0);
            $table->bigInteger('DisposalLoss')->nullable()->default(0);
            $table->bigInteger('RefundLoss')->nullable()->default(0);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profit_analyses');
    }
};