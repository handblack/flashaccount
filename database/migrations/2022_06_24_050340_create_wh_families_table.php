<?php

use App\Models\WhFamily;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_families', function (Blueprint $table) {
            $table->id();
            $table->string('familyname',60);
            $table->string('shortname',30);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->timestamps();
        });
        $row = new WhFamily();
        $row->create([
            'familyname' => 'SIN FAMILIA',
            'shortname' => 'S/F',
            'token' => md5(1),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_families');
    }
}
