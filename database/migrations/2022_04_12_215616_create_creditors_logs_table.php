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
        Schema::create('creditors_logs', function (Blueprint $table) {
            $table->id();
            $table->string('SID');
            $table->string('PID');
            $table->string('DID');
            $table->string('CreditCard');
            $table->bigInteger('CreditAmount')->nullable();
            $table->bigInteger('PaidAmount')->default(0);
            $table->bigInteger('Balance');
            $table->integer('Year');
            $table->integer('Month');
            $table->string('CreditStatus')->default('true');
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
        Schema::dropIfExists('creditors_logs');
    }
};