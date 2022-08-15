<?php

use App\Models\WhReason;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reasonname');
            $table->string('shortname')->nullable();
            $table->enum('typereason',['LIN','LOU','LTR','LIV']);
            $table->string('token',60);
            $table->timestamps();
        });
        $this->CreateReason('LIN','INGRESO POR COMPRAS');
        $this->CreateReason('LIN','INGRESO POR DEVOLUCION');
        $this->CreateReason('LOU','SALIDA POR VENTAS');
        $this->CreateReason('LOU','SALIDA POR DEVOLUCION');
        $this->CreateReason('LTR','TRANSFERENCIA');
        $this->CreateReason('LIV','AJUSTE DE INVENTARIO');
    }

    private function CreateReason($tp,$name){
        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $row = new WhReason();
        $row->create([
            'typereason'=>$tp,
            'reasonname'=>$name,
            'token' => $hash->encode(WhReason::all()->count('id') + 1),
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_reasons');
    }
}
