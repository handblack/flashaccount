<?php

use App\Models\WhTax;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('taxname',30);
            $table->string('shortname',30);
            $table->double('ratio',12,5)->default(0);
            $table->timestamps();
        });
        $row = new WhTax();
        $row->taxname = 'IGV 18%';
        $row->shortname = '18%';
        $row->ratio = 18;
        $row->save();
        $row = new WhTax();
        $row->taxname = 'INAFECTO';
        $row->shortname = '0%';
        $row->ratio = 0;
        $row->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_taxes');
    }
}
