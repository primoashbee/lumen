<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('disbursement_payment_method_id');
            $table->unsignedInteger('repayment_payment_method_id');
            $table->unsignedInteger('recovery_payment_method_id');
            $table->unsignedInteger('deposit_payment_method_id');
            $table->unsignedInteger('withdrawal_payment_method_id');
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
        Schema::dropIfExists('default_payment_methods');
    }
}
