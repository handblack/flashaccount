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

        $this->CreateWarehouse('ALPR','ALMACEN PRINCIPAL');
        $this->CreateWarehouse('W01TR','TIENDA LIMA / TRANSFERENCIA');
        $this->CreateWarehouse('W01LI','TIENDA LIMA');
        $this->CreateWarehouse('W02TR','TIENDA PROVINCIA / TRANSFERENCIA');
        $this->CreateWarehouse('W02PR','TIENDA PROVINCIA');

      
    }

    public function CreateWarehouse($sn,$na){
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhWarehouse();
        $row->create([
            'warehousename' => $na,
            'shortname' => $sn,
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
