<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhLInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_l_inputs', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->date('dateacct')->nullable();
            $table->foreignId('bpartner_id');
            $table->foreignId('warehouse_id');
            $table->foreignId('reason_id');
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
        Schema::dropIfExists('wh_l_inputs');
    }
}
