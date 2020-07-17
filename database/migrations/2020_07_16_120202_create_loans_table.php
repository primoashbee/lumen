<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_id')->unique();
            $table->mediumText('description')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('account_per_client');

            $table->integer('interest_calculation_method_id');

            $table->integer('minimum_installment');
            $table->integer('default_installment');
            $table->integer('maximum_installment');

            $table->integer('installment_length'); 
            $table->integer('installment_method');
            
            $table->string('interest_interval');
            $table->string('interest_rate');

            $table->integer('loan_minimum_amount');
            $table->integer('loan_maximum_amount');

            $table->integer('grace_period');

            $table->boolean('has_tranches')->default(false);

            $table->integer('tranch_1_amount')->nullable();
            $table->integer('tranch_2_amount')->nullable();
            $table->integer('tranch_3_amount')->nullable();
            $table->integer('tranch_4_amount')->nullable();
            $table->integer('tranch_5_amount')->nullable();


            $table->unsignedInteger('loan_portfolio_active');
            $table->unsignedInteger('loan_portfolio_in_arrears');
            $table->unsignedInteger('loan_portfolio_in_matured');

            $table->unsignedInteger('loan_interest_income_active');
            $table->unsignedInteger('loan_interest_income_in_arrears');
            $table->unsignedInteger('loan_interest_income_in_matured');

            $table->unsignedInteger('loan_write_off');
            $table->unsignedInteger('loan_write_recovery');

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
        Schema::dropIfExists('loans');
    }
}
