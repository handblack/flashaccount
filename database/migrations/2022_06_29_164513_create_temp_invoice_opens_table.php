<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempInvoiceOpensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_invoice_opens', function (Blueprint $table) {
            $table->id();
            $table->string('session',60);
            $table->date('datetrx');
            $table->date('datedue');
            $table->foreignId('bpartner_id')->nullable();
            $table->foreignId('cinvoice_id')->nullable();
            $table->foreignId('pinvoice_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->float('amount',12,5);
            $table->float('amountopen',12,5);
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
        Schema::dropIfExists('temp_invoice_opens');
    }
}
