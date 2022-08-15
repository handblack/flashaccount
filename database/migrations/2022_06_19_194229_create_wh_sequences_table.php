<?php

use App\Models\WhDocType;
use App\Models\WhSequence;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $group_id = 3;

    public function up()
    {
        Schema::create('wh_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctype_id')->nullable();
            $table->string('token',60);
            $table->string('serial',4);
            $table->string('tag',20)->nullable();
            $table->integer('lastnumber')->default(0);
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->enum('isdocref',['Y','N'])->default('N');
            $table->enum('isfex',['Y','N'])->default('Y');
            $table->enum('isdefault',['Y','N'])->default('N');
            $table->foreignId('warehouse_id')->nullable();
            $table->timestamps();
        });
        $hash = new Hashids(env('APP_HASH'));
        /*
            ----------------------------------------------------------------------
            VENTAS
            ----------------------------------------------------------------------
        */
        // FEX - Comprobantes
        $row  = new WhSequence();
        $this->group_id = 2;
        $this->CreateSequence('FAC','F001'); // Factura1
        $this->CreateSequence('FAC','F002'); // Factura2
        $this->CreateSequence('FAC','F003'); // Factura3
        $this->CreateSequence('BVE','B001'); // Boleta de Venta1
        $this->CreateSequence('BVE','B002'); // Boleta de Venta2
        $this->CreateSequence('BVE','B003'); // Boleta de Venta3        
        $this->CreateSequence('NCR','F001'); // Nota de Credito
        $this->CreateSequence('NCR','F002'); // Nota de Credito
        $this->CreateSequence('NCR','F003'); // Nota de Credito
        $this->CreateSequence('NCR','B001'); // Nota de Credito
        $this->CreateSequence('NCR','B002'); // Nota de Credito
        $this->CreateSequence('NCR','B003'); // Nota de Credito
        $this->CreateSequence('NDB','F001'); // Nota de Debito
        $this->CreateSequence('NDB','F002'); // Nota de Debito
        $this->CreateSequence('NDB','F003'); // Nota de Debito
        $this->CreateSequence('NDB','B001'); // Nota de Debito
        $this->CreateSequence('NDB','B002'); // Nota de Debito
        $this->CreateSequence('NDB','B003'); // Nota de Debito
        // Transaccionales
        $this->group_id = 3;
        $this->CreateSequence('OVE','OV01'); // Orden Venta1
        $this->CreateSequence('OVE','OV02'); // Orden Venta2
        /*
            ----------------------------------------------------------------------
            COMPRAS
            Comprobante de Compra - Solo se usa como secuenciador interno para el codigo de asiento contable
            ----------------------------------------------------------------------
        */
        $this->CreateSequence('OCO','OC01'); // Orden Compra
        $this->CreateSequence('OCO','OC02'); // Orden Compra
        $this->CreateSequence('OCO','OC03'); // Orden Compra
        $this->CreateSequence('OCO','OC04'); // Orden Compra
        // solo trabajan 1 serie
        $this->CreateSequence('CCP','0001'); // Comprobante de Compra
        $this->CreateSequence('CNC','0001'); // Nota de Credito
        $this->CreateSequence('CND','F002'); // Nota de Debito    
        /*
            ----------------------------------------------------------------------
            LOGISTICA
            ----------------------------------------------------------------------
        */
        // Ingresos
        $this->CreateSequence('LIN','I001');
        $this->CreateSequence('LIN','I002');
        $this->CreateSequence('LIN','I003');
        // Salidas
        $this->CreateSequence('LOU','S001');
        $this->CreateSequence('LOU','S002');
        $this->CreateSequence('LOU','S003');
        // Transferencias
        $this->CreateSequence('LTR','TR01');
        $this->CreateSequence('LTR','TR02');
        $this->CreateSequence('LTR','TR03');
        // Inventario
        $this->CreateSequence('LIV','INV1');
        $this->CreateSequence('LIV','INV2');
        $this->CreateSequence('LIV','INV3');        
        /*
            ----------------------------------------------------------------------
            BANCO
            ----------------------------------------------------------------------
        */
        $this->CreateSequence('BIN','0001'); // Banco Ingreso
        $this->CreateSequence('BEX','0001'); // Banco Expense
        $this->CreateSequence('BAL','0001'); // Reconciliacion

    }

    private function CreateSequence($t,$s){
        $filter = [
            ['shortname',$t],
            ['group_id',$this->group_id]
        ];
        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $row  = new WhSequence();
        $row->create([
            'doctype_id' => WhDocType::where($filter)->first()->id,
            'serial'     => $s,
            'token'      => $hash->encode(WhSequence::all()->count('id') + 1),
            'warehouse_id' => 1,
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_sequences');
    }
}
