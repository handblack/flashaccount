<?php

use App\Models\WhDocType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhDocTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_doc_types', function (Blueprint $table) {
            $table->id();
            $table->string('doctypename',60);
            $table->string('doctypecode',10)->nullable();
            $table->string('shortname',10)->nullable();
            $table->string('value',5)->nullable();
            $table->integer('orden')->default(1);
            $table->foreignId('group_id')->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhDocType();
        // Documento de Identidad
        $row->create([
            'doctypename' => 'REGISTRO UNICO DEL CONTRIBUYENTE',            
            'shortname'   => 'RUC',
            'isactive'    => 'Y',
            'group_id'    => 1,
        ]);
        $row->create([
            'doctypename' => 'DOCUMENTO NACIONAL DE IDENTIDAD',
            'shortname'   => 'DNI',
            'isactive'    => 'Y',
            'group_id'    => 1,
        ]);
        // Tipo de Comprobante ELECTRONICO - VENTAS
        $row->create([
            'doctypename' => 'FACTURA ELECTRONICA',
            'shortname'   => 'FAC',
            'isactive'    => 'Y',
            'doctypecode' => '01',
            'group_id'    => 2,
        ]);
        $row->create([
            'doctypename' => 'BOLETA ELECTRONICA',
            'shortname'   => 'BVE',
            'isactive'    => 'Y',
            'doctypecode' => '03',
            'group_id'    => 2,
        ]);
        $row->create([
            'doctypename' => 'NOTA CREDITO ELECTRONICO',
            'shortname'   => 'NCR',
            'isactive'    => 'Y',
            'doctypecode' => '07',
            'group_id'    => 2,
        ]);
        $row->create([
            'doctypename' => 'NOTA DEBITO ELECTRONICO',
            'shortname'   => 'NDB',
            'isactive'    => 'Y',
            'doctypecode' => '08',
            'group_id'    => 2,
        ]);
        $row->create([
            'doctypename' => 'GUIA REMISION REMITENTE',
            'shortname'   => 'GRR',
            'isactive'    => 'Y',
            'doctypecode' => '09',
            'group_id'    => 2,
        ]);
        $row->create([
            'doctypename' => 'GUIA REMISION TRANSPORTISTA',
            'shortname'   => 'GRT',
            'isactive'    => 'Y',
            'doctypecode' => '09',
            'group_id'    => 2,
        ]);
        // Tipo de documentos transaccionales ----------------------------------------------
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'OVE','doctypename' => 'ORDEN DE VENTA',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'OCO','doctypename' => 'ORDEN DE COMPRA',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'LIN','doctypename' => 'Parte de Ingreso',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'LOU','doctypename' => 'Parte de Salida',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'LTR','doctypename' => 'Parte de Transferencia',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'LIV','doctypename' => 'Parte de Inventario',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'BAL','doctypename' => 'Reconciliacion',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'BIN','doctypename' => 'Ingreso',]);
        $row->create(['group_id' => 3,'isactive' => 'Y','shortname' => 'BEX','doctypename' => 'Egreso',]);
        // Tipo de documentos compras ------------------------------------------------------
        $row->create(['group_id' => 4,'doctypecode' => '01','shortname' => 'FAC','isactive' => 'Y','doctypename' => 'FACTURA']);
        $row->create(['group_id' => 4,'doctypecode' => '03','shortname' => 'BVE','isactive' => 'Y','doctypename' => 'BOLETA DE VENTA']);
        $row->create(['group_id' => 4,'doctypecode' => '07','shortname' => 'NCR','isactive' => 'Y','doctypename' => 'NOTA CREDITO']);
        $row->create(['group_id' => 4,'doctypecode' => '08','shortname' => 'NDB','isactive' => 'Y','doctypename' => 'NOTA DEBITO']);
        $row->create(['group_id' => 4,'doctypecode' => '00','shortname' => 'REC','isactive' => 'Y','doctypename' => 'RECIBO HONORARIO']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_doc_types');
    }
}
