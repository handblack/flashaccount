<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBAllocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_b_allocates', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->date('dateacct')->nullable();
            $table->string('period',6)->nullable();
            $table->foreignId('bpartner_id'); 
            $table->foreignId('bankaccount_id')->nullable();
            $table->float('rate'); 
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
        Schema::dropIfExists('wh_b_allocates');
    }
}
