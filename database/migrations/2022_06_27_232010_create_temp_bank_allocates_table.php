<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBankAllocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bank_allocates', function (Blueprint $table) {
            $table->id();
            $table->date('datetrx');
            $table->date('dateacct')->nullable();
            $table->string('period',6)->nullable();
            $table->foreignId('bpartner_id'); 
            $table->foreignId('bankaccount_id')->nullable();
            $table->float('rate'); 
            $table->string('token',60);
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
        Schema::dropIfExists('temp_bank_allocates');
    }
}
