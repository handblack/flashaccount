<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhCInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_c_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->enum('typeproduct',['S','P']);
            $table->foreignId('typeoperation_id');            
            $table->foreignId('orderline_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('um_id');
            $table->foreignId('tax_id');
            $table->float('quantity',12,5)->default(0);
            $table->float('priceunit',12,5)->default(0);
            $table->float('priceunittax',12,5)->default(0);
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
            $table->string('token',60)->nullable();

            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')
                                    ->references('id')
                                    ->on('wh_c_invoices')
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
        Schema::dropIfExists('wh_c_invoice_lines');
    }
}
