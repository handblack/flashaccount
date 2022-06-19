<?php

use App\Models\WhProductFamily;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhProductFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_product_families', function (Blueprint $table) {
            $table->id();
            $table->string('pfname',50);
            $table->timestamps();
        });
        $row = new WhProductFamily();
        $row->pfname = 'SIN LINEA';
        $row->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_product_families');
    }
}
