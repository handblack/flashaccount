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
            $table->foreignId('address_id');
            $table->string('token',60);
            $table->timestamps();
        });

        $this->CreateWarehouse('W00AL','ALMACEN PRINCIPAL',1);
        $this->CreateWarehouse('W01TR','TIENDA LIMA - TRANSFERENCIA',1);
        $this->CreateWarehouse('W01LI','TIENDA LIMA',1);
        $this->CreateWarehouse('W02TR','TIENDA PROVINCIA - TRANSFERENCIA',2);
        $this->CreateWarehouse('W02PR','TIENDA PROVINCIA',2);

      
    }

    public function CreateWarehouse($sn,$na,$adr){
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhWarehouse();
        $row->create([
            'warehousename' => $na,
            'shortname'  => $sn,
            'isactive'   => 'Y',
            'address_id' => $adr,
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
