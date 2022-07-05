<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_c_credits', function (Blueprint $table) {
            $table->id();
            $table->date('datecredit');
            $table->date('dateacct');
            $table->string('period');
            $table->foreignId('bpartner_id');
            $table->foreignId('invoice_id');
            $table->foreignId('doctype_id')->nullable();
            $table->foreignId('sequence_id');
            $table->foreignId('warehouse_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->string('serial',5)->nullable();
            $table->string('documentno',15)->nullable();
            /* Inicio de Referencia */
            $table->date('ref_datetrx')->nullable();
            $table->foreignId('ref_sequence_id');
            $table->foreignId('ref_doctype_id');
            $table->string('ref_serial',5);
            $table->string('ref_documentno',15);
            /* Fin de referencia */
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
        Schema::dropIfExists('temp_c_credits');
    }
}
