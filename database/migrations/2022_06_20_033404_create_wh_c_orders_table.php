<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhCOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_c_orders', function (Blueprint $table) {
            $table->id();
            $table->date('dateorder');
            $table->foreignId('bpartner_id');
            $table->foreignId('sequence_id');
            $table->string('serial',4);
            $table->string('documentno',15);
            $table->foreignId('currency_id');
            $table->foreignId('warehouse_id')->nullable();
            $table->string('token',60);
            $table->float('amount',12,2)->default(0);
            $table->enum('docstatus',['O','C','A'])->default('O');
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
        Schema::dropIfExists('wh_c_orders');
    }
}
