<?php

use App\Models\WhProductLine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhProductLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_product_lines', function (Blueprint $table) {
            $table->id();
            $table->string('plname',50);
            $table->timestamps();
        });
        $row = new WhProductLine();
        $row->plname = 'SIN LINEA';
        $row->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_product_lines');
    }
}
