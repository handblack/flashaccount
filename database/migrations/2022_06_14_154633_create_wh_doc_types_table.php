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
    private $group_id;

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
        /* Socio_Negocio - Tipo de Documento de Identidad */
        $this->group_id = 1;
        $this->CreateDocType('6','RUC','REGISTRO UNICO DEL CONTRIBUYENTE');
        $this->CreateDocType('1','DNI','DOCUMENTO NACIONAL DE IDENTIDAD');
        /* 
            ----------------------------------------------------------------------------------
            FEX - Facturacion Electronica 
            ----------------------------------------------------------------------------------
        */
        // Tipo de Comprobante ELECTRONICO - VENTAS
        $this->group_id = 2;
        $this->CreateDocType('01','FAC','FACTURA ELECTRONICA');
        $this->CreateDocType('03','BVE','BOLETA DE VENTA ELECTRONICA');
        $this->CreateDocType('07','NCR','NOTA DE CREDITO ELECTRONICA');
        $this->CreateDocType('08','NDB','NOTA DE DEBITO ELECTRONICA');
        $this->CreateDocType('09','GRR','GUIA DE REMISION');
        /* 
            ----------------------------------------------------------------------------------
            DOCUMENTOS TRANSACCIONALES 
            ----------------------------------------------------------------------------------
        */
        $this->group_id = 3;
        $row = new WhDocType();
        // Tipo de documentos transaccionales ( GROUP_ID_3 ) ----------------------------------------------
        // Ventas        
        $this->CreateDocType('','OVE','Orden de Venta');
        // Compras
        $this->CreateDocType('','OCO','Orden de Compra');
        $this->CreateDocType('','CCP','Comprobante de Compra');
        $this->CreateDocType('','CNC','Nota de Credito');
        $this->CreateDocType('','CND','Nota de Debito');
        // Logistica
        $this->CreateDocType('','LIN','Parte de Ingreso');
        $this->CreateDocType('','LOU','Parte de Salida');
        $this->CreateDocType('','LTR','Parte de Transferencia');
        $this->CreateDocType('','LIV','Parte de Inventario');
        // Bancos
        $this->CreateDocType('','BAL','Reconciliacion');
        $this->CreateDocType('','BIN','Banco Ingreso');
        $this->CreateDocType('','BEX','Banco Egreso');
        // Tipo de documentos compras ------------------------------------------------------
        $this->group_id = 4;
        $this->CreateDocType('01','FAC','FACTURA');
        $this->CreateDocType('03','BVE','BOLETA DE VENTA');
        $this->CreateDocType('07','BVE','NOTA DE CREDITO');
        $this->CreateDocType('08','BVE','NOTA DE DEBITO');
        $this->CreateDocType('','BVE','RECIBO POR HONORARIO');
        $this->CreateDocType('','BVE','RECIBO SERVICIO PUBLICO');
        
    }

    public function CreateDocType($code,$short,$ident){
        $row = new WhDocType();
        $row->create([
            'doctypename' => $ident,
            'shortname'   => $short,
            'isactive'    => 'Y',
            'doctypecode' => $code,
            'group_id'    => $this->group_id,
        ]);
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
