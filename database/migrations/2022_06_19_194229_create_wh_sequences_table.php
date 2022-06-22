<?php

use App\Models\WhSequence;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctype_id')->nullable();
            $table->string('token',60);
            $table->string('serial',4);
            $table->string('tag',20)->nullable();
            $table->integer('lastnumber')->default(0);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->enum('isdocref',['Y','N'])->default('N');
            $table->enum('isfex',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhSequence();
        $row->tag    = 'corder';
        $row->serial = 'P001';
        $row->token  = md5(1);
        $row->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_sequences');
    }
}
