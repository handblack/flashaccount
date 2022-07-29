<?php

use App\Models\WhPriceList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('pricelistname',100);
            $table->string('shortname',50)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhPriceList();
        $row->create(['pricelistname' => 'LISTA PRECIO PUBLICO']);
        $row->create(['pricelistname' => 'LISTA PRECIO MAYORISTA']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_price_lists');
    }
}
