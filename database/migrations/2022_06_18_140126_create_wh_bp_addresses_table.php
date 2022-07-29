<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpartner_id');
            $table->foreignId('bpartner_country_id')->nullable();
            $table->foreignId('bpartner_state_id')->nullable();
            $table->foreignId('bpartner_county_id')->nullable();
            $table->foreignId('bpartner_city_id')->nullable();
            $table->string('token',60)->nullable();
            $table->string('address',200)->nullable();
            $table->string('reference',100)->nullable();
            $table->string('shortname',50)->nullable();
            $table->string('ubigeo',8)->nullable();
            $table->string('zipcode',15)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
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
        Schema::dropIfExists('wh_bp_addresses');
    }
}
