<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempLogisticInventoryLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_logistic_inventory_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->float('quantity',12,5)->default(0)->nullable();
            $table->float('package',12,5)->default(0)->nullable();
            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')
                                    ->references('id')
                                    ->on('temp_logistic_inventories')
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
        Schema::dropIfExists('temp_logistic_inventory_lines');
    }
}
