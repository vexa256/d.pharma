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
        Schema::create('drug_categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('DCID')->unique();
            $table->string('CategoryName')->unique();
            $table->text('CategoryDescription')->nullable();
            //$table->string('MeasurementUnits');
            $table->timestamps();
        });

        DrugExportControlsEurope();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_categories');
    }
};
