<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpartner_id');            
            $table->string('contactname',100)->nullable();
            $table->string('workplace',100)->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
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
        Schema::dropIfExists('wh_bp_contacts');
    }
}
