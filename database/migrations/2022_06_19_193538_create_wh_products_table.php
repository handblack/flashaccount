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
        
        $row->create($this->item('RESINA POLYCLARK UG500 CILINDRO 220KG'));
        $row->create($this->item('RESINA PREACELERA RLMT400 CILINDRO 220KG'));
        $row->create($this->item('JERSEY 80 ALGONDON 30/1 CRUDO'));
        $row->create($this->item('JERSEY 80 MELANGE 30/1 CRUDO'));
        $row->create($this->item('JERSEY 80 POLYCOTON 30/1 CRUDO'));
        $row->create($this->item('JERSEY 90 ALGONDON 30/1 CRUDO'));
        $row->create($this->item('JERSEY 90 MELANGE 30/1 CRUDO'));
        $row->create($this->item('JERSEY 90 POLYCOTON 30/1 CRUDO'));
        $row->create($this->item('GAMUZA 80 POLYCOTON 30/1 CRUDO'));
        $row->create($this->item('GAMUZA 80 ALGODON 30/1 CRUDO'));
        $row->create($this->item('GAMUZA 80 MELANGE 30/1 CRUDO'));
        
        $row->create($this->item('GAMUZA 90 ALGODON 30/1 PATO BB'));
        $row->create($this->item('GAMUZA 90 ALGODON 30/1 ROJO'));
        $row->create($this->item('GAMUZA 90 ALGODON 30/1 AZUL'));
        $row->create($this->item('GAMUZA 90 ALGODON 30/1 MARINO'));

        $row->create($this->item('HILADO 50/1 PIMA'));
        $row->create($this->item('HILADO 30/1 POLYALGODON'));
        $row->create($this->item('HILADO 30/1 ALGODON'));
        $row->create($this->item('HILADO 24/1 ALGODON'));
        $row->create($this->item('HILADO 12/1 ALGODON'));
        $row->create($this->item('HILADO 10/1 ALGODON'));
        $row->create($this->item('HILADO 30/1 MELANGE'));
        $row->create($this->item('HILADO 24/1 MELANGE'));
        $row->create($this->item('HILADO 12/1 MELANGE'));
        $row->create($this->item('HILADO 10/1 MELANGE'));

    }

    private function item($d){
        $hash = new Hashids(env('APP_HASH'));
        return [
            'productcode' => WhProduct::orderBy('productcode','desc')->first()->productcode + 1,
            'productname' => $d,
            'family_id' => 1,
            'line_id' => 1,
            'um_id' => 1,
            'token' => $hash->encode(WhProduct::all()->count('id') + 1),
        ];
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
