<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempLogisticInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_logistic_inventories', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->foreignId('warehouse_id');
            $table->foreignId('sequence_id');
            $table->foreignId('reason_id');
            $table->enum('movetype',['I','O']);
            $table->string('glosa',200)->nullable();
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
        Schema::dropIfExists('temp_logistic_inventories');
    }
}
