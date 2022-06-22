<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhCOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_c_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corder_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('um_id');
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
        Schema::dropIfExists('wh_c_order_lines');
    }
}
