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
        Schema::create('drug_reserves', function (Blueprint $table) {
            $table->id();
            $table->string('DID')->nullable();
            $table->string('ActiveStatus')->default('false');
            $table->string('LicenseHolder')->nullable();
            $table->string('LocalDistributor')->nullable();
            $table->string('DrugName')->nullable();
            $table->string('GenericName')->nullable();
            $table->string('CountryOfOrigin')->nullable();
            $table->string('DosageForm')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        EjectOveridesInUkraineServers();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_reserves');
    }
};