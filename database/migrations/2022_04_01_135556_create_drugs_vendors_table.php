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
        Schema::create('drugs_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('VID')->unique();
            $table->string('Name')->unique();
            $table->string('Address');
            $table->date('ContractExpiry');
            $table->string('ContractValidity')->default('valid');
            $table->string('ActiveStatus')->default('true');
            $table->integer('MonthsToContractExpiry')->nullable();
            $table->string('Email')->unique();
            $table->string('Phone')->unique();
            $table->string('ContactPerson');
            $table->text('Remarks');
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
        Schema::dropIfExists('drugs_vendors');
    }
};