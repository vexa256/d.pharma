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
        Schema::create('dispense_logs', function (Blueprint $table) {
            $table->id();
            $table->string('TransactionID');
            $table->string('DrugName');
            $table->string('PatientName');
            $table->string('CreditCard');
            $table->text('Comments')->nullable();
            $table->string('SID');
            $table->string('StockID')->nullable();
            $table->string('DID')->nullable();
            $table->string('PID')->nullable();
            $table->string('GenericName')->nullable();
            $table->string('DispensedBy');
            $table->string('PatientPhone')->nullable();
            $table->string('PatientEmail')->nullable();
            $table->string('RecordKey')->nullable();
            $table->string('PaymentMode');
            $table->string('Units');
            $table->string('Month')->nullable();
            $table->string('Year')->nullable();
            $table->string('Currency')->default('UGX');
            $table->bigInteger('Qty');
            $table->bigInteger('SubTotal');
            $table->bigInteger('SellingPrice');
            $table->bigInteger('ProjectedProfit');
            $table->string('BatchNumber');
            $table->string('CreditStatus')->default('false');
            $table->string('ProcessingStatus')->default('false');
            $table->string('ExistingStatus')->default('false');
            //$table->string('CreditStatus')->default('false');
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
        Schema::dropIfExists('dispense_logs');
    }
};