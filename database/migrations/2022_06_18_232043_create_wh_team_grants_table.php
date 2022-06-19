<?php

use App\Models\WhTeamGrant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhTeamGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_team_grants', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('module',100);
            $table->string('url',200)->nullable();
            $table->foreignId('team_id');
            $table->enum('isgrant',['Y','N','D'])->default('N');
            $table->enum('iscreate',['Y','N','D'])->default('N');
            $table->enum('isread',['Y','N','D'])->default('N');
            $table->enum('isupdate',['Y','N','D'])->default('N');
            $table->enum('isdelete',['Y','N','D'])->default('N');
            $table->enum('isactive',['Y','N','D'])->default('N');
            $table->string('token',60)->nullable();
            $table->timestamps();
        });

        $grant = new WhTeamGrant();
        $grant->create(['name'=>'','team_id'=>1,'module' => 'system.user']);
        $grant->create(['name'=>'','team_id'=>1,'module' => 'system.team']);
        $grant->create(['name'=>'','team_id'=>1,'module' => 'system.team.line']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_team_grants');
    }
}
