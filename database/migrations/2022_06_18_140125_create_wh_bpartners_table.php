<?php

use App\Models\WhBpartner;
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
            $table->string('token',60);
            $table->timestamps();
        });
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhBpartner();
        $row->create([
            'bpartnercode' => 'C20606384387',
            'bpartnername' => 'GRUPO SBF PERU S.A.C.',
            'token' => $hash->encode(1),
        ]);
        $row->create([
            'bpartnercode' => 'C20602367615',
            'bpartnername' => 'COMERCIAL PICHARA PERU S.A.C.',
            'token' => $hash->encode(2),
        ]);
        $row->create([
            'bpartnercode' => 'C20100039207',
            'bpartnername' => 'RANSA COMERCIAL S A',
            'token' => $hash->encode(3),
        ]);
        $row->create([
            'bpartnercode' => 'C20109072177',
            'bpartnername' => 'CENCOSUD RETAIL PERU S.A.',
            'token' => $hash->encode(4),
        ]);
        $row->create([
            'bpartnercode' => 'P20100041953',
            'bpartnername' => 'RIMAC SEGUROS Y REASEGUROS',
            'token' => $hash->encode(5),
        ]);
        $row->create([
            'bpartnercode' => 'C10099766838',
            'bpartnername' => 'RIVAS CAMPOS MARIA LOURDES',
            'token' => $hash->encode(6),
        ]);
        $row->create([
            'bpartnercode' => 'P20331898008',
            'bpartnername' => 'LUZ DEL SUR S.A.A.',
            'token' => $hash->encode(7),
        ]);
        $row->create([
            'bpartnercode' => 'P20330791412',
            'bpartnername' => 'ENEL GENERACION PERU S.A.A.',
            'token' => $hash->encode(7),
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
