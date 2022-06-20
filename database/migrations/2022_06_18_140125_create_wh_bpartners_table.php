<?php

use App\Models\WhBpartner;
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
        $row = new WhBpartner();
        $row->create([
            'bpartnercode' => 'C20606384387',
            'bpartnername' => 'GRUPO SBF PERU S.A.C.',
            'token' => md5(1),
        ]);
        $row->create([
            'bpartnercode' => 'C20602367615',
            'bpartnername' => 'COMERCIAL PICHARA PERU S.A.C.',
            'token' => md5(2),
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
