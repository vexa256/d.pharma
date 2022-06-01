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

        \DB::unprepared("INSERT INTO `patient_packages` (`id`, `uuid`, `PackageID`, `PackageName`, `PackageAccountValueInLocalCurrency`, `BillingStatus`, `PackageDescription`, `status`, `created_at`, `updated_at`) VALUES
        (1, '$2y$10$2NOuz1dEEAX4RcfjBluL8OuQQUbso3fT.yFEdaMXVaLRoO9005dnK', 'defaultPackage', 'Default Clinic Package', 0, 'Patient Billable', '<p>defaultPackage<br></p>', 'true', '2022-05-30 08:08:25', '2022-05-30 20:08:59');");
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