<?php

use App\Models\WhWarehouse;
use Hashids\Hashids;
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
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhWarehouse();
        $row->create([
            'warehousename' => 'ALMACEN LIMA',
            'shortname' => 'APL01',
            'isactive' => 'Y',
            'token' => $hash->encode(WhWarehouse::all()->count('id') + 1),
        ]);
        $row->create([
            'warehousename' => 'ALMACEN OLIVOS',
            'shortname' => 'APL02',
            'isactive' => 'Y',
            'token' => $hash->encode(WhWarehouse::all()->count('id') + 1),
        ]);
        $row->create([
            'warehousename' => 'TIENDA LIMA',
            'shortname' => 'TDA01',
            'isactive' => 'Y',
            'token' => $hash->encode(WhWarehouse::all()->count('id') + 1),
        ]);
        $row->create([
            'warehousename' => 'TIENDA PROVINCIA',
            'shortname' => 'TDA02',
            'isactive' => 'Y',
            'token' => $hash->encode(WhWarehouse::all()->count('id') + 1),
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
