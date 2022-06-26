<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBIncomePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_b_income_payments', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->foreignId('bankaccount_id');
            $table->foreignId('paymentmethod_id');
            $table->foreignId('currency_id');
            $table->double('rate',3)->default(1);
            $table->string('documentno',20)->nullable();
            $table->float('amount',12,5)->default(0);
            $table->float('amountconverted',12,5)->default(0);

           
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
        Schema::dropIfExists('wh_b_income_payments');
    }
}
