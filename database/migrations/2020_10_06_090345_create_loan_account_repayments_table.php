<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAccountRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_account_repayments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->unsignedInteger('loan_account_id');
            $table->unsignedDouble('interest_paid');
            $table->unsignedDouble('principal_paid');
            
            $table->unsignedDouble('total_paid');
            $table->unsignedInteger('paid_by');
            $table->unsignedInteger('payment_method_id');

            $table->unsignedInteger('for_pretermination')->default(false);
            $table->dateTime('repayment_date');
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('loan_account_repayments');
    }
}
