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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('PackageID');
            $table->string('PID');
            $table->string('Name');
            $table->string('Email');
            $table->string('Phone');
            $table->string('Address');
            $table->bigInteger('PatientsAge');
            $table->bigInteger('PatientAccount')->default(0);
            $table->string('Gender');
            $table->string('NextOfKeenName');
            $table->string('NextOfKeenGender');
            $table->string('NextOfKeenAddress');
            $table->string('NextOfKeenPhone');
            $table->string('NextOfKeenEmail');
            $table->string('NextOfKeenRelationship');
            $table->text('KnownAllergies');
            $table->text('RelevantMedicalNotes');
            $table->string('status')->nullable()->default('true');
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
        Schema::dropIfExists('patients');
    }
};