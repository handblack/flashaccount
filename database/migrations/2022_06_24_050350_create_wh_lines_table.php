<?php

use App\Models\WhLine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_lines', function (Blueprint $table) {
            $table->id();
            $table->string('linename',60);
            $table->string('shortname',30);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->timestamps();
        });
        $row = new WhLine();
        $row->create([
            'linename' => 'SIN LINEA',
            'shortname' => 'S/L',
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
        Schema::dropIfExists('wh_lines');
    }
}
