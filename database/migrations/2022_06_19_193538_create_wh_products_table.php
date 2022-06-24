<?php

use App\Models\WhProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_products', function (Blueprint $table) {
            $table->id();
            $table->string('productcode',15)->unique();
            $table->string('productname',200);
            $table->string('shortname',50)->nullable();
            $table->foreignId('family_id');
            $table->foreignId('line_id');
            $table->foreignId('um_id');
            $table->string('token',60);
            $table->timestamps();
        });
        $row = new WhProduct();
        $row->create([
            'productcode' => '1000',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM NEGRO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => md5('1'),
        ]);
        $row->create([
            'productcode' => '1001',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM AZUL',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => md5('2'),
        ]);
        $row->create([
            'productcode' => '1002',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM ROJO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => md5('3'),
        ]);
        $row->create([
            'productcode' => '1003',
            'productname' => 'LAPICERO PILOT BPS-GP-F-B NEGRO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => md5('3'),
        ]);
        $row->create([
            'productcode' => '1004',
            'productname' => 'DOÑA PEPA',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => md5('3'),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_products');
    }
}
