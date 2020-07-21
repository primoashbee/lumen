<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->unsignedInteger('loan_id');

            $table->integer('interest_calculation_method_id');
            $table->integer('installment');

            $table->integer('loan_amount')->nullable();
            $table->double('interest')->nullable();

            $table->string('status')->default('pending');

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('approved_by');
            $table->unsignedInteger('disbursed_by');

            $table->dateTime('approved_at',0);
            $table->dateTime('disbursed_at',0);

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
        Schema::dropIfExists('loan_accounts');
    }
}
