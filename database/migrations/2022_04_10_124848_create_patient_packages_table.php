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
        Schema::create('patient_packages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('PackageID');
            $table->string('PackageName');
            $table->bigInteger('PackageAccountValueInLocalCurrency')->default(0)
                ->nullable();
            $table->string('BillingStatus')->default('Patient Billable');
            $table->text('PackageDescription');
            $table->string('status')->default('true');
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
        Schema::dropIfExists('patient_packages');
    }
};