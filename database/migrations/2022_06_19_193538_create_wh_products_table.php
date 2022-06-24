<?php

use App\Models\WhProduct;
use Hashids\Hashids;
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
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhProduct();
        $row->create([
            'productcode' => '1000',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM NEGRO',
            'family_id'   => 1,
            'line_id'     => 1,
            'um_id'       => 1,
            'token' => $hash->encode(1),
        ]);
        $row->create([
            'productcode' => '1001',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM AZUL',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(2),
        ]);
        $row->create([
            'productcode' => '1002',
            'productname' => 'LAPICERO TRILUX 032 MEDIUM ROJO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(3),
        ]);
        $row->create([
            'productcode' => '1003',
            'productname' => 'LAPICERO PILOT BPS-GP-F-B NEGRO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(4),
        ]);
        $row->create([
            'productcode' => '1004',
            'productname' => 'SOLVENTE 3 PETRO',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(6),
        ]);
        $row->create([
            'productcode' => '1005',
            'productname' => 'RESINA POLICLARK UG300 CILINDRO 220KG',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(7),
        ]);
        $row->create([
            'productcode' => '1006',
            'productname' => 'RESINA POLICLARK UG400 CILINDRO 220KG',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(8),
        ]);
        $row->create([
            'productcode' => '1007',
            'productname' => 'RESINA PREACELERADA RLMT400 CILINDRO 220KG                                                                                                                                                                                       ',
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(8),
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
