<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_b_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctype_id')->nullable();
            $table->foreignId('sequence_id')->nullable();
            $table->string('sequenceserial',4)->nullable();
            $table->string('sequenceno',15)->nullable();
            $table->date('datetrx');
            $table->foreignId('bankaccount_id');
            $table->foreignId('bpartner_id');
            $table->foreignId('currency_id');
            $table->float('amount',12,5)->default(0);
            $table->float('amountopen',12,5)->default(0);
            $table->float('amountanticipation',12,5)->default(0);
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
        Schema::dropIfExists('wh_b_incomes');
    }
}
