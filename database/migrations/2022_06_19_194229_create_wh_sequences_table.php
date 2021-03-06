<?php

use App\Models\WhDocType;
use App\Models\WhSequence;
use Hashids\Hashids;
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
        $hash = new Hashids(env('APP_HASH'));
        /*
            Comproban de Venta
        */
        $row  = new WhSequence();
        $row->create([
            'doctype_id' => WhDocType::where('shortname','FAC')->first()->id,
            'serial'     => 'F001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','BVE')->first()->id,
            'serial'     => 'B001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','NCR')->first()->id,
            'serial'     => 'B001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','NCR')->first()->id,
            'serial'     => 'F001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        /*
            Orden de Venta
        */
        $row  = new WhSequence();
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OVE')->first()->id,
            'serial'     => 'OV01',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OVE')->first()->id,
            'serial'     => 'OV02',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        /*
            Orden de COMPRA
        */
        $row  = new WhSequence();
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OCO')->first()->id,
            'serial'     => 'OC01',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','OCO')->first()->id,
            'serial'     => 'OC02',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        /*
            ----------------------------------------------------------------------
            LOGISTICA
            ----------------------------------------------------------------------
        */
        $row->create([
            'doctype_id' => WhDocType::where('shortname','LIN')->first()->id,
            'serial'     => 'LOG1',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','LOU')->first()->id,
            'serial'     => 'LOG1',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','LTR')->first()->id,
            'serial'     => 'LOG1',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','LIV')->first()->id,
            'serial'     => 'LOG1',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
        /*
            ----------------------------------------------------------------------
            BANCO
            ----------------------------------------------------------------------
        */
        $row->create([
            'doctype_id' => WhDocType::where('shortname','BAL')->first()->id,
            'serial'     => '0001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','BIN')->first()->id,
            'serial'     => '0001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
        ]);
        $row->create([
            'doctype_id' => WhDocType::where('shortname','BEX')->first()->id,
            'serial'     => '0001',
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
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
