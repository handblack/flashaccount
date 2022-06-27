<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBExpenseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_b_expense_lines', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('expense_id');
            $table->foreign('expense_id')
                                    ->references('id')
                                    ->on('wh_b_expenses')
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
        Schema::dropIfExists('wh_b_expense_lines');
    }
}
