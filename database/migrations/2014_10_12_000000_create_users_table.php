<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Hashids\Hashids;

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

        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $row = new User();
        $row->name     = 'elias.fuentes';
        $row->email    = 'soporte@miasoftware.net';
        $row->password = Hash::make('x5w93kra');
        $row->token    = $hash->encode(User::all()->count('id') + 1);
        $row->isadmin  = 'Y';
        $row->isactive = 'Y';
        $row->current_team_id = 1;
        $row->save();

        $row = new User();
        $row->name     = 'miriam.villaorduna';
        $row->email    = 'miriam@miasoftware.net';
        $row->password =  Hash::make('x5w93kra');
        $row->token    = $hash->encode(User::all()->count('id') + 1);
        $row->isadmin  = 'N';
        $row->isactive = 'Y';
        $row->current_team_id = 1;
        $row->save();
        /*
        for ($i = 1; $i <= 2; $i++) {
            $row = new User();
            $row->name     = "test{$i}.debug";
            $row->email    = "usuario{$i}@miasoftware.net";
            $row->password =  Hash::make('1234');
            $row->token    = md5($i+2); 
            $row->current_team_id = 3;
            $row->save();
        }
        */
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
