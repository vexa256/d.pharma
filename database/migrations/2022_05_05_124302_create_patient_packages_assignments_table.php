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
        Schema::create('patient_packages_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('PID');
            $table->string('PatientName');
            $table->string('Phone');
            $table->string('Address');
            $table->string('PackageID');
            $table->string('PackageName');
            $table->string('PackageValue');
            $table->string('ExpiryStatus')->DEFA;
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
        Schema::dropIfExists('patient_packages_assignments');
    }
};