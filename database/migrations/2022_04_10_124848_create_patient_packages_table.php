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
        (1, '$2y$10$2NOuz1dEEAX4RcfjBluL8OuQQUbso3fT.yFEdaMXVaLRoO9005dnK', 'defaultPackage', 'Default Clinic Package', 0, 'Patient Billable', '<p>defaultPackage<br></p>', 'true', '2022-05-30 05:08:25', '2022-05-30 17:08:59'),
        (2, '$2y$10\$i5GvHBcvx39RiQnOtIY/7uZcDPs1MhjL0u3tUEJClf8o4JwNEoc7a', '$2y$10\$QyA5GQwnKEGOKmvTwHj.juKJ8sN8.LR31pdY4J./NmCcdJAP6La2a', 'IVF PATIENTS', 4000000, 'Hospital Billable', '<p>vexa256@gmail.comvexa256@gmail.comvexa256@gmail.comvexa256@gmail.com<br></p>', 'true', '2022-06-07 23:17:31', '2022-06-08 11:17:43'),
        (3, '$2y$10\$eO9tjxIAlv/b2ILw1FNqv.gYVsicVhZd523fwEUg0gJbzzhbfO6NK', '$2y$10\$xBroEhdpUv6dl6Iz5.JhCu2CfgTNSJ2wrRdkoGm8EwRQIrW2kXfle', 'Staff Package', 22222222222222, 'Hospital Billable', '<p>This Package is for staff members</p>', 'true', '2022-06-11 00:24:23', '2022-06-11 00:25:32');");
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
