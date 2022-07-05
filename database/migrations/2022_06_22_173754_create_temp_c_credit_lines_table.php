<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCCreditLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_c_credit_lines', function (Blueprint $table) {
            $table->id();
            $table->enum('typeproduct',['S','P']);
            $table->foreignId('typeoperation_id');
            $table->foreignId('product_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('um_id')->nullable();          
            $table->foreignId('tax_id')->nullable();
            $table->float('quantity',12,5)->default(0);
            $table->float('priceunit',12,5)->default(0);
            $table->float('priceunittax',12,5)->default(0);
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
            $table->string('token',60)->nullable();
            $table->foreignId('invoiceline_id')->nullable();

            $table->unsignedBigInteger('credit_id');
            $table->foreign('credit_id')
                                    ->references('id')
                                    ->on('temp_c_credits')
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
        Schema::dropIfExists('temp_c_credit_lines');
    }
}
