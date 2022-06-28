<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankAllocateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_allocate_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_id');
            $table->foreignId('expense_id');
            $table->foreignId('cinvoice_id');
            $table->foreignId('pinvoice_id');
            
            $table->unsignedBigInteger('allocate_id');
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
        Schema::dropIfExists('temp_bank_allocate_lines');
    }
}
