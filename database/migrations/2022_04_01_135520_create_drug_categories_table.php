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
        \DB::unprepared("
        INSERT INTO `drug_categories` (`id`, `uuid`, `DCID`, `CategoryName`, `CategoryDescription`, `created_at`, `updated_at`) VALUES

        (14, '', '$2y$10\$rZEiYF8QcV6/bxd85XjAXOMTteIl0E.z64N8867KooWyDDnl9kabW', 'Human Medicine', '<p>Human Medicine<br></p>', '2022-05-26 07:34:19', NULL);
        ");
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