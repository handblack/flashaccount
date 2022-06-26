<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankIncomeLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_income_lines', function (Blueprint $table) {
            $table->id();           
            $table->foreignId('invoice_id');
            $table->text('description')->nullable();
            $table->date('datetrx')->nullable();
            $table->date('datedue')->nullable();
            $table->float('amount',12,5)->default(0);

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
        Schema::dropIfExists('temp_bank_income_lines');
    }
}
