<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx')->nullable();
            $table->foreignId('bankaccount_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('bpartner_id')->nullable();
            $table->foreignId('paymentmethod_id')->nullable();
            $table->double('rate',3)->default(1);
            $table->string('documentno',30)->nullable();
            $table->float('amount',12,5)->nullable();
            $table->string('token',60)->nullable();
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
        Schema::dropIfExists('temp_bank_expenses');
    }
}
