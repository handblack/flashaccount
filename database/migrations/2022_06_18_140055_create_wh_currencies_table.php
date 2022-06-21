<?php

use App\Models\WhCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currencyname',20);
            $table->timestamps();
        });
        $row = new WhCurrency();
        $row->currencyname = 'SOLES';
        $row->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_currencies');
    }
}
