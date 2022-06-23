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
        // Tipo de Comprobante ELECTRONICO
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
            'doctypename' => 'GUIA REMISION',
            'shortname'   => 'NDB',
            'isactive'    => 'Y',
            'doctypecode' => '09',
            'group_id'    => 2,
        ]);
        // Tipo de documentos transaccionales
        $row->create([
            'doctypename' => 'ORDEN DE VENTA',
            'shortname'   => 'OVE',
            'isactive'    => 'Y',
            'group_id'    => 3,
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
