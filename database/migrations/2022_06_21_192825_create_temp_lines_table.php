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
            $table->string('session',80)->nullable();
            $table->string('token',60)->nullable();
            $table->enum('typeproduct',['P','S'])->default('P');
            $table->foreignId('tax_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('um_id')->nullable();
            $table->string('umname',30)->nullable();
            $table->string('umshortname',15)->nullable();
            $table->string('productcode',15)->nullable();
            $table->text('description')->nullable();
            $table->double('qty',12,5)->nullable();
            $table->double('priceunit',12,5)->nullable();
            $table->double('priceunittax',12,5)->nullable();
            $table->double('it_base',12,5)->nullable();
            $table->double('it_exo',12,5)->nullable();
            $table->double('it_tax',12,5)->nullable();
            $table->double('it_grand',12,5)->nullable();
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
