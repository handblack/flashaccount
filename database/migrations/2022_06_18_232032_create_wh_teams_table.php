<?php

use App\Models\WhTeam;
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
        $row = new WhTeam();
        $row->create([
            'teamname' => 'Administradores',
            'token'    => md5('ab'), 
        ]);
        $row->create([
            'teamname' => 'Supervisores',
            'token'    => md5('abc'), 
        ]);
        $row->create([
            'teamname' => 'Usuarios',
            'token'    => md5('abcd'), 
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
