<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temp_id')->nullable();
            $table->foreignId('orderline_id')->nullable();
            $table->string('session',60)->nullable();
            $table->string('token',60)->nullable();
            $table->enum('typeproduct',['P','S'])->default('P');
            $table->foreignId('typeoperation_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('tax_id')->nullable();
            $table->foreignId('um_id')->nullable();
            $table->string('umname',30)->nullable();
            $table->string('umshortname',15)->nullable();
            $table->string('productcode',15)->nullable();
            $table->text('description')->nullable();
            $table->float('quantity',12,5)->default(0);
            $table->float('priceunit',12,5)->default(0);
            $table->float('priceunittax',12,5)->default(0)->nullable();
            $table->float('amountbase',12,5)->default(0);
            $table->float('amountexo',12,5)->default(0);
            $table->float('amounttax',12,5)->default(0);
            $table->float('amountgrand',12,5)->default(0);
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
        Schema::dropIfExists('temp_lines');
    }
}
