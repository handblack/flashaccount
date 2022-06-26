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
            $table->string('session',60)->nullable();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('sequence_id');
            $table->foreignId('bpartner_id');
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('warehouse_id')->nullable();
            $table->float('amountgrand',12,5)->default(0);
            $table->string('token',60)->nullable();
            $table->date('datetrx')->nullable();
            $table->date('dateacct')->nullable();
            $table->date('datedue')->nullable();
            $table->float('amount',12,2)->default(0);
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
