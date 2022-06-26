<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankIncomePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_income_payments', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx')->nullable();
            $table->foreignId('bankaccount_id');
            $table->foreignId('currency_id');
            $table->foreignId('bpartner_id');
            $table->foreignId('paymentmethod_id');
            $table->float('amount',12,5);
            $table->string('documentno',30)->nullable();

            $table->unsignedBigInteger('income_id');
            $table->foreign('income_id')
                                    ->references('id')
                                    ->on('temp_bank_incomes')
                                    ->cascadeOnDelete();
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
        Schema::dropIfExists('temp_bank_income_payments');
    }
}
