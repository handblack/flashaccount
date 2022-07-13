<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhPOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_p_orders', function (Blueprint $table) {
            $table->id();
            $table->date('dateorder');
            $table->date('dateacct')->nullable();
            $table->date('datedue')->nullable();
            $table->string('period',6);
            $table->foreignId('bpartner_id');
            $table->foreignId('sequence_id');
            $table->foreignId('doctype_id')->nullable();
            $table->enum('typepayment',['C','R'])->default('C'); // C=Contado  / R=Credito
            $table->string('serial',5)->nullable();
            $table->string('documentno',15)->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('warehouse_id')->nullable();
            $table->string('token',60)->nullable();
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
            $table->float('amountopen',12,5)->default(0);
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
        Schema::dropIfExists('wh_p_orders');
    }
}
