<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id')->unique();
            $table->boolean('is_self_employed');
            $table->string('service_type')->nullable();
            $table->boolean('is_employed');
            $table->string('position')->nullable();
            $table->string('company_name')->nullable();
            $table->integer('monthly_gross_income');

            //spouse
            $table->boolean('spouse_is_self_employed');
            $table->string('spouse_service_type')->nullable();
            $table->boolean('spouse_is_employed');
            $table->string('spouse_position')->nullable();
            $table->string('spouse_company_name')->nullable();
            $table->integer('spouse_monthly_gross_income');

            $table->boolean('has_remittance');
            $table->integer('remittance_amount')->nullable();

            $table->boolean('has_pension');
            $table->integer('pension_amount')->nullable();

            $table->integer('total_household_income');

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
        Schema::dropIfExists('household_incomes');
    }
}
