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
            $table->string('shortname',20)->nullable();
            $table->string('iso',5)->nullable();
            $table->timestamps();
        });
        $row = new WhCurrency();
        $row->currencyname = 'SOLES';
        $row->iso = 'PEN';
        $row->save();
        $row = new WhCurrency();
        $row->currencyname = 'DOLARES';
        $row->iso = 'USD';
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
