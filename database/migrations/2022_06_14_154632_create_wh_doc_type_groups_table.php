<?php

use App\Models\WhDocTypeGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhDocTypeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_doc_type_groups', function (Blueprint $table) {
            $table->id();
            $table->string('groupname',100);
            $table->string('shortname',30)->nullable();
            $table->timestamps();
        });
        $row = new WhDocTypeGroup();
        $row->create(['groupname' => 'Socio_Negocio - Tipo Documento de Identidad ']);
        $row->create(['groupname' => 'FEX - Facturacion Electronica','shortname'=>'FEX']);
        $row->create(['groupname' => 'TRX - Documentos transaccionales','shortname'=>'TRX']);
        $row->create(['groupname' => 'Compras - Tipo de Comprobante de Compras']);
        $row->create(['groupname' => 'Usuarios - Tipo Documento de Identidad ']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_doc_type_groups');
    }
}
