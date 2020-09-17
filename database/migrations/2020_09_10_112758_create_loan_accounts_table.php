<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('loan_id');
            $table->double('amount');
            $table->double('principal');
            $table->double('interest');
            $table->double('interest_rate');
            $table->integer('number_of_installments');
            $table->double('total_deductions'); 
            $table->double('disbursed_amount'); //net disbursement

            $table->unsignedInteger('approved_by')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamp('approved_at');
            
            $table->unsignedInteger('disbursed_by')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->boolean('disbursed')->default(false);

            $table->date('first_payment');
            $table->date('last_payment');
            
            
            $table->unsignedInteger('created_by')->nullable();

            $table->longText('notes')->nullable();
            $table->string('status')->default('Pending Approval');
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
