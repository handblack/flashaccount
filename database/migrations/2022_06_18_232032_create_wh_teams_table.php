<?php

use App\Models\WhTeam;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_teams', function (Blueprint $table) {
            $table->id();
            $table->string('teamname',50);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60)->nullable();
            $table->timestamps();
        });

        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $row = new WhTeam();
        $row->create([
            'teamname' => 'Administradores',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Supervisores',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Usuarios',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo Almacen',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo Compras',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo Ventas',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo Bancos',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo Produccion',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        $row->create([
            'teamname' => 'Solo POS Ventas',
            'token'    => $hash->encode(WhTeam::all()->count('id') + 1), 
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_teams');
    }
}
