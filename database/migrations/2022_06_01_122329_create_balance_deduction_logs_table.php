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
        Schema::create('balance_deduction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('_unique');
            $table->bigInteger('AmountUsed');
            $table->bigInteger('Balance');
            $table->string('RegisteredBy');
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
        Schema::dropIfExists('balance_deduction_logs');
    }
};
