<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhTeamGrantSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_team_grant_schedules', function (Blueprint $table) {
            $table->id();
            for ($s = 0; $s <= 6; $s++) {
                for ($i = 0; $i <= 23; $i++) {
                    $ho = str_pad($i,2,'0',STR_PAD_LEFT);
                    $table->enum("schedule_{$s}_{$ho}",['Y','N'])->default('Y');        
                }
            }
            $table->foreignId('team_id');
            $table->foreign('team_id')
                                    ->references('id')
                                    ->on('wh_teams')
                                    ->cascadeOnDelete();
            $table->unique('team_id');
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
        Schema::dropIfExists('wh_team_grant_schedules');
    }
}
