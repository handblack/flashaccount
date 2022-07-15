<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhLOutputLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_l_output_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderline_id');
            $table->foreignId('product_id');
            $table->float('quantity',12,5)->default(0)->nullable();
            $table->float('package',12,5)->default(0)->nullable();
            $table->foreignId('output_id');
            $table->foreign('output_id')
                                    ->references('id')
                                    ->on('wh_l_outputs')
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
        Schema::dropIfExists('wh_l_output_lines');
    }
}
