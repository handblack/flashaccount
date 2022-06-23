<?php

use App\Models\WhWarehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehousename',100);
            $table->string('shortname',15);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->timestamps();
        });
        $row = new WhWarehouse();
        $row->create([
            'warehousename' => 'ALMACEN PRINCIPAL',
            'shortname' => 'APL01',
            'isactive' => 'Y',
            'token' => 'abcde',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_warehouses');
    }
}
