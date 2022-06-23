<?php

use App\Models\WhDocType;
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
            $table->foreignId('warehouse_id')->nullable();
            $table->timestamps();
        });
       
        //Orden de Venta
        $row = new WhSequence();
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OVE')->first()->id,
            'serial'     => 'O001',
            'token'      => md5('1'),
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OVE')->first()->id,
            'serial'     => 'O002',
            'token'      => md5('2'),
        ]);
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
