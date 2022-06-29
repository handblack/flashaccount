<?php

use App\Models\WhParam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_params', function (Blueprint $table) {
            $table->id();
            $table->string('identity',200);
            $table->string('shortname',50)->nullable();
            $table->string('value',100)->nullable();
            $table->foreignId('group_id');
            $table->foreignId('parent_id')->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->enum('isrequired',['Y','N'])->default('N');
            $table->enum('isfixed',['Y','N'])->default('N');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
        $row = new WhParam();
        $row->create(['group_id' => 1,'identity' => 'CONTADO']);
        $row->create(['group_id' => 1,'identity' => 'CREDITO']);
        $row->create(['group_id' => 2,'shortname'=>'BCP','identity' => 'BANCO DE CREDITO DEL PERU']);
        $row->create(['group_id' => 2,'shortname'=>'BBVA','identity' => 'BANCO CONTINENTAL']);
        $row->create(['group_id' => 2,'shortname'=>'INTB','identity' => 'BANCO INTERBANK DEL PERU']);
        $row->create(['group_id' => 2,'shortname'=>'EFEC','identity' => 'CAJA EFECTIVO']);
        $row->create(['group_id' => 3,'identity' => 'OPERACION GRABADA']);
        $row->create(['group_id' => 3,'identity' => 'OPERACION INAFECTA']);
        $row->create(['group_id' => 3,'identity' => 'OPERACION EXONERADA']);
        $row->create(['group_id' => 4,'shortname' => 'EFE','identity' => 'EFECTIVO']);
        $row->create(['group_id' => 4,'shortname' => 'DEP','identity' => 'DEPOSITO']);        
        $row->create(['group_id' => 4,'shortname' => 'VDE','identity' => 'PASARELA TARJETA DEBITO']);        
        $row->create(['group_id' => 4,'shortname' => 'VCR','identity' => 'PASARELA TARJETA CREDITO']);        
        $row->create(['group_id' => 5,'shortname' => 'EFE','identity' => 'EFECTIVO']);
        $row->create(['group_id' => 5,'shortname' => 'DEP','identity' => 'DEPOSITO']);        
        $row->create(['group_id' => 5,'shortname' => 'CHE','identity' => 'CHEQUE']);        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_params');
    }
}
