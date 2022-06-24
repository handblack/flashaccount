<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('sequence_id');
            $table->foreignId('bpartner_id');
            $table->foreignId('currency_id');
            $table->float('amountgrand',12,5)->default(0);
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
        Schema::dropIfExists('temp_headers');
    }
}
