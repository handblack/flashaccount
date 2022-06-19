<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('current_team_id')->default(1);
            $table->enum('isadmin',['Y','N'])->default('N');
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->rememberToken();
            $table->string('token',60)->nullable();
            $table->timestamps();
        });
        $row = new User();
        $row->name     = 'elias.fuentes';
        $row->email    = 'soporte@miasoftware.net';
        $row->password =  Hash::make('x5w93kra');
        $row->current_team_id = 1;
        $row->save();
        $row = new User();
        $row->name     = 'test.debug';
        $row->email    = 'usuario@miasoftware.net';
        $row->password =  Hash::make('1234');
        $row->current_team_id = 3;
        $row->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_users');
    }
}
