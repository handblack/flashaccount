<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhTeamGrantSerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_team_grant_serials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sequence_id');     
            $table->foreignId('team_id');
            $table->foreign('team_id')
                                    ->references('id')
                                    ->on('wh_teams')
                                    ->cascadeOnDelete();
            $table->unique(['team_id','sequence_id']);
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
        Schema::dropIfExists('wh_team_grant_serials');
    }
}
