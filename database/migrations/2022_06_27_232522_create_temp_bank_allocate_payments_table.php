<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankAllocatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_allocate_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_id')->nullable();
            $table->foreignId('expense_id')->nullable();
            $table->float('amount',12,5)->default(0);
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('allocate_id');
            $table->foreign('allocate_id')
                                    ->references('id')
                                    ->on('temp_bank_allocates')
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
        Schema::dropIfExists('temp_bank_allocate_payments');
    }
}
