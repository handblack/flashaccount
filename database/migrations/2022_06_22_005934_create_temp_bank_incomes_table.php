<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('token',60)->nullable();
            $table->foreignId('bpartner_id');
            $table->date('datetrx');
            $table->float('amount',12,5)->default(0);
            $table->float('amountopen',12,5)->default(0);
            $table->float('amountanticipation',12,5)->default(0);
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
        Schema::dropIfExists('temp_bank_incomes');
    }
}
