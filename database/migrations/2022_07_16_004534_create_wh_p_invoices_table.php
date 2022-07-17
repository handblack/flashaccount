<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhPInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_p_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('dateinvoiced');
            $table->date('datedue')->nullable();
            $table->date('dateacct')->nullable();
            $table->string('period',6);
            $table->foreignId('order_id');
            $table->foreignId('bpartner_id');
            $table->foreignId('currency_id');
            $table->foreignId('doctype_id');
            $table->foreignId('sequence_id')->nullable();
            $table->string('sequencenro',15);
            $table->string('serial',4);
            $table->string('documentno',15);
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
            $table->float('amountopen',12,5)->default(0);
            $table->float('rate',12,5)->default(1);
            $table->string('token',60)->nullable();
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
        Schema::dropIfExists('wh_p_invoices');
    }
}
