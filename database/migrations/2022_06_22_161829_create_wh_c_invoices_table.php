<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhCInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_c_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('dateinvoiced');
            $table->date('datedue')->nullable();
            $table->date('dateacct')->nullable();
            $table->string('period',6);
            $table->foreignId('order_id')->nullable();
            $table->foreignId('bpartner_id');
            $table->foreignId('sequence_id');
            $table->foreignId('doctype_id');
            $table->string('serial',4);
            $table->string('documentno',15);
            $table->foreignId('currency_id');
            $table->foreignId('warehouse_id')->nullable();
            $table->string('token',60);
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
            $table->float('amountopen',12,5)->default(0);
            $table->float('rate',12,5)->default(1);
            $table->enum('docstatus',['O','C'])->default('O');
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
        Schema::dropIfExists('wh_c_invoices');
    }
}
