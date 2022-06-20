<?php

use App\Models\WhUm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhUmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_ums', function (Blueprint $table) {
            $table->id();
            $table->string('umname',30);
            $table->string('shortname',15);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhUm();
        $row->create([
            'umname' => 'UNIDAD',
            'shortname' => 'UND',
            'isactive' => 'Y',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_ums');
    }
}
