<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhLTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_l_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->date('dateacct')->nullable();
            $table->foreignId('warehouse_id');
            $table->foreignId('warehouse_to_id');
            $table->foreignId('sequence_id');
            $table->string('serial',5);
            $table->string('documentno',15);
            $table->string('glosa',200)->nullable();
            $table->enum('docstatus',['O','C','A'])->default('C');
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
        Schema::dropIfExists('wh_l_transfers');
    }
}