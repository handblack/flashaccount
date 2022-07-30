<?php

use App\Models\WhBpartner;
use App\Models\WhDocType;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bpartners', function (Blueprint $table) {
            $table->id();
            $table->string('bpartnercode',12)->unique();
            $table->string('bpartnername',150);
            $table->enum('typeperson',['C','P']);
            $table->enum('legalperson',['N','J']);
            $table->foreignId('doctype_id');
            $table->string('documentno');
            $table->string('lastname',60)->nullable(); // Apellido paterno
            $table->string('firstname',60)->nullable(); // Apellido materno
            $table->string('prename',60)->nullable(); // nombre
            $table->text('fex_email')->nullable(); // Enviod e coreo
            $table->enum('istaxpriceunit',['Y','N'])->default('Y');
            $table->foreignId('pricelist_id')->nullable();
            $table->foreignId('sales_doctype_id')->nullable();
            $table->foreignId('address_fiscal_id')->nullable();
            $table->foreignId('address_delivery_id')->nullable();
            $table->string('token',60);
            $table->timestamps();
        });
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhBpartner();
        $filter = [
            ['shortname','RUC'],
            ['group_id','1'],
        ];
        
        $row->create([
            'bpartnercode' => 'C20606384387',
            'bpartnername' => 'GRUPO SBF PERU S.A.C.',
            'typperson' => 'C',
            'legalperson' => 'J',
            'doctype_id'  => WhDocType::where($filter)->first()->id,
            'documentno'  => '20606384387',
            'token' => $hash->encode(WhBpartner::all()->count('id') + 1),
        ]);
        $row->create([
            'bpartnercode' => 'C00000000000',
            'bpartnername' => 'CLIENTE GENERICO',
            'typperson' => 'C',
            'legalperson' => 'J',
            'doctype_id'  => WhDocType::where($filter)->first()->id,
            'documentno'  => '00000000000',
            'token' => $hash->encode(WhBpartner::all()->count('id') + 1),
        ]);
        $row->create([
            'bpartnercode' => 'C20602367615',
            'bpartnername' => 'COMERCIAL PICHARA PERU S.A.C.',
            'typperson' => 'C',
            'legalperson' => 'J',
            'doctype_id'  => WhDocType::where($filter)->first()->id,
            'documentno'  => '20602367615',
            'token' => $hash->encode(WhBpartner::all()->count('id') + 1),
        ]);
     
        $row->create([
            'bpartnercode' => 'P20331898008',
            'bpartnername' => 'LUZ DEL SUR S.A.A.',
            'typperson' => 'P',
            'legalperson' => 'J',
            'doctype_id'  => WhDocType::where($filter)->first()->id,
            'documentno'  => '20331898008',
            'token' => $hash->encode(WhBpartner::all()->count('id') + 1),
        ]);
        $row->create([
            'bpartnercode' => 'P20100047056',
            'bpartnername' => 'TOPY TOP S A',
            'typperson' => 'P',
            'legalperson' => 'J',
            'doctype_id'  => WhDocType::where($filter)->first()->id,
            'documentno'  => '20100047056',
            'token' => $hash->encode(WhBpartner::all()->count('id') + 1),
        ]);
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bpartners');
    }
}
