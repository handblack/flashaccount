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
            $table->foreignId('bpartner_id');
            $table->foreignId('currency_id');
            $table->foreignId('doctype_id');
            $table->string('serial',10);
            $table->string('documentno',15);
            $table->float('amountgrand')->default(0);
            $table->float('amountopen')->default(0);
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
        Schema::dropIfExists('wh_p_invoices');
    }
}
