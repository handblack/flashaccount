<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempLogisticOutputLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_logistic_output_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->float('quantity',12,5)->default(0)->nullable();
            $table->float('package',12,5)->default(0)->nullable();
            $table->unsignedBigInteger('output_id');
            $table->foreign('output_id')
                                    ->references('id')
                                    ->on('temp_logistic_outputs')
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
        Schema::dropIfExists('temp_logistic_output_lines');
    }
}
