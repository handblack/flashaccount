<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhLTransferLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_l_transfer_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->float('quantity',12,5)->default(0)->nullable();
            $table->float('package',12,5)->default(0)->nullable();
            $table->unsignedBigInteger('transfer_id');
            $table->foreign('transfer_id')
                                    ->references('id')
                                    ->on('wh_l_transfers')
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
        Schema::dropIfExists('wh_l_transfer_lines');
    }
}
