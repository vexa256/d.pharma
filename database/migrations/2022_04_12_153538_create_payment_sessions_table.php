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
        Schema::create('payment_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('SID');
            $table->string('PID')->nullable();
            $table->string('StockID');
            $table->string('BillableStatus')->nullable();
            $table->string('Existing')->default('true')->nullable();
            $table->string('PatientName');
            $table->string('PatientPhone');
            $table->string('PatientEmail');
            $table->string('DrugName');
            $table->string('GenericName');
            $table->string('Units');
            $table->bigInteger('UnitCost');
            $table->bigInteger('Qty');
            $table->bigInteger('SubTotal');
            $table->string('DispensedBy');
            $table->string('CreditStatus')->default('false');
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
        Schema::dropIfExists('payment_sessions');
    }
};