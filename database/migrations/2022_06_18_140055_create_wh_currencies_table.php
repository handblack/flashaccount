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
            $table->string('currencyiso',5)->unique();
            $table->string('shortname',20)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('prefix',5)->nullable();
            $table->string('suffix',5)->nullable();
            $table->string('token',60)->nullable();
            $table->timestamps();
        });
        $row = new WhCurrency();
        $row->create([
            'currencyname' => 'SOLES',
            'currencyiso'  => 'PEN',
            'prefix'       => 'S/',
            'isactive'     => 'Y',
            'token'        => 'asd087eoerw',
        ]);
        $row->create([
            'currencyname' => 'DOLARES',
            'currencyiso'  => 'USD',
            'prefix'       => '$',
            'isactive'     => 'Y',
            'token'        => 'pq93kasua',
        ]);

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
