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
      

        $row->create($this->item('HILADO 50/1 PIMA'));
        $row->create($this->item('HILADO 40/1 PEINADO'));
        $row->create($this->item('HILADO 30/1 POLYESTER 100%'));
        $row->create($this->item('HILADO 30/1 POLYCOTTON'));
        $row->create($this->item('HILADO 30/1 MELANGE 3%'));
        $row->create($this->item('HILADO 30/1 JASPE 5%'));
        $row->create($this->item('HILADO 30/1 JASPE 12%'));
        $row->create($this->item('HILADO 30/1 JASPE 10%'));
        $row->create($this->item('HILADO 30/1 ALGODON 100%'));
        $row->create($this->item('HILADO 28/1 POLYESTER 100%'));
        $row->create($this->item('HILADO 28/1 POLYCOTTON'));
        $row->create($this->item('HILADO 28/1 JASPE 5%'));
        $row->create($this->item('HILADO 28/1 JASPE 3%'));
        $row->create($this->item('HILADO 28/1 JASPE 12%'));
        $row->create($this->item('HILADO 28/1 JASPE 10%'));
        $row->create($this->item('HILADO 28/1 ALGODON 100%'));
        $row->create($this->item('HILADO 24/1 POLYESTER 100%'));
        $row->create($this->item('HILADO 24/1 POLYCOTTON'));
        $row->create($this->item('HILADO 24/1 JASPE 5%'));
        $row->create($this->item('HILADO 24/1 JASPE 3%'));
        $row->create($this->item('HILADO 24/1 JASPE 12%'));
        $row->create($this->item('HILADO 24/1 JASPE 10%'));
        $row->create($this->item('HILADO 24/1 ALGODON 100%'));
        $row->create($this->item('HILADO 20/1 ALGODON 100%'));
        $row->create($this->item('HILADO 12/1 ALGODON 100%'));
        $row->create($this->item('HILADO 10/1 ALGODON 100%'));

        $row->create($this->item('CUELLOS 24/1 ALGODON 32X9   BLANCO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 ANTIQUE'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 ARENA'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 AZULINO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 BOTELLA'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 CEMENTO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 CHOCOLATE'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 MARINO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 MELANGE 10 %'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 MELANGE 25%'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 NEGRO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 PLATA'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 ROJO'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40 SOMBRA'));
$row->create($this->item('CUELLOS 24/1 ALGODON 40X10 BLANCO'));
$row->create($this->item('DOBLE PIQUE ALGODON 24/1 90 AZULINO'));
$row->create($this->item('DOBLE PIQUE ALGODON 24/1 90 BLANCO'));
$row->create($this->item('DOBLE PIQUE ALGODON 24/1 90 MARINO'));
$row->create($this->item('DOBLE PIQUE ALGODON 24/1 90 NEGRO'));
$row->create($this->item('DOBLE PIQUE ALGODON 24/1 90 ROJO'));
$row->create($this->item('FALSO INTERLOCK 30/1 ALGODON 80 BLANCO'));
$row->create($this->item('FALSO INTERLOCK 30/1 ALGODON 80 CELESTE'));
$row->create($this->item('FALSO INTERLOCK 30/1 ALGODON 80 PATO'));
$row->create($this->item('FALSO INTERLOCK 30/1 ALGODON 80 ROSADO'));
$row->create($this->item('FALSO INTERLOCK 30/1 ALGODON 80 VERDE AGUA'));
$row->create($this->item('FARNELA 20/10 ALGODON 90 MILITAR'));
$row->create($this->item('FRANELA  20/10 ALGODON 90 TURQUEZA MEDIO'));
$row->create($this->item('FRANELA 10/10 POLYALGODON 90 NEGRO'));
$row->create($this->item('FRANELA 20/10 ALGODON 100 MELANGE 25%'));
$row->create($this->item('FRANELA 20/10 ALGODON 90'));
$row->create($this->item('FRANELA 20/10 ALGODON 90 ACERO'));
$row->create($this->item('FRANELA 20/10 ALGODON 90 ARENA'));
$row->create($this->item('FRANELA 20/10 ALGODON 90 AZUL'));
$row->create($this->item('FRANELA 20/10 ALGODON 90 TURQUEZA'));
$row->create($this->item('FRANELA 20/10 ALGODON 90 VERDE'));
$row->create($this->item('FRANELA 20/10 POLYALGODON 90 AZUL JEAN'));
$row->create($this->item('FRANELA 20/10 POLYALGODON 90 BLANCO'));
$row->create($this->item('FRANELA 20/10 POLYALGODON 90 CELESTE'));
$row->create($this->item('FRANELA 20/10 POLYALGODON 90 VERDE AGUA'));
$row->create($this->item('FRANELA 20/10ALGODON 90'));
$row->create($this->item('FRANELA 24/10 ALGODON 95 MELANGE'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 AZULINO'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 BARNIE'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 CHICLE'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 ROJO'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 TURQUEZA'));
$row->create($this->item('GAMUZA 30/1 ALGODON 90 TURQUEZA MEDIO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 90 AQUA'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 90 BANANA'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 90 BLANCO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 90 CELESTE'));
 
$row->create($this->item('GAMUZA 30/1 POLYALGODON 93 PATO BB'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 93 ROSADO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 93 VERDE AGUA'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 AZULINO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 BLANCO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 CELESTE'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 LIMON'));
 
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 ROSADO'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 TURQUEZA'));
$row->create($this->item('GAMUZA 30/1 POLYALGODON 94 VERDE AGUA'));
$row->create($this->item('GAMUZA 50/1 ALGODON 80'));
$row->create($this->item('GAMUZA 50/1 ALGODON 80 BLANCO'));
$row->create($this->item('GAMUZA 50/1 ALGODON 80 CHICLE'));
$row->create($this->item('GAMUZA 50/1 ALGODON 80 MARINO 2'));
$row->create($this->item('GAMUZA 50/1 ALGODON 80 TURQUEZA'));
$row->create($this->item('JERSEY 20/1 ALGODON 80 BLANCO'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 LIMON'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 MAIZ'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 MANDARINA'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 MANZANA'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 MARINO'));
$row->create($this->item('JERSEY 20/1 ALGODON 90 MARRON'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 BLANCO'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 BOTELLA'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 ITALIANO'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 LACRE'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 LIMON'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 LONDON'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 MARINO'));
 
$row->create($this->item('JERSEY 30/1 ALGODON 58 PERICO'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 PISTACHO'));
$row->create($this->item('JERSEY 30/1 ALGODON 58 PLATA'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 CONCHO DE VINO'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 CREMA'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 DUNA'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 FRESA'));
 
$row->create($this->item('JERSEY 30/1 ALGODON 80 LIMON'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 LONDON'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 MAIZ'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 MANDARINA'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 TURQUEZA MEDIO'));
$row->create($this->item('JERSEY 30/1 ALGODON 80 VERDE AGUA'));
$row->create($this->item('JERSEY 30/1 ALGODON 82 ORO'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 ARENA'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 AZULINO'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 AZULINO 19'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 BEIGE'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 BLANCO'));
 
$row->create($this->item('JERSEY 30/1 ALGODON 85 CHICLE'));
$row->create($this->item('JERSEY 30/1 ALGODON 85 CHOCOLATE'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 MARINO'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 MILITAR'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 NARANGA'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 NEGRO'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 ORO'));
$row->create($this->item('JERSEY 30/1 ALGODON 87 PARICO'));
 
$row->create($this->item('JERSEY 30/1 ALGODON 90 SOMBRA'));
$row->create($this->item('JERSEY 30/1 ALGODON 90 TURQUEZA'));
$row->create($this->item('JERSEY 30/1 ALGODON 90 TURQUEZA MEDIO'));
$row->create($this->item('JERSEY 30/1 ALGODON 90 VERDE AGUA'));
$row->create($this->item('JERSEY 30/1 ALGODON 90 VERDE OLIVO'));
$row->create($this->item('JERSEY 30/1 ALGODON 94 BLANCO'));
$row->create($this->item('JERSEY 30/1 ALGODON NEGRO'));
$row->create($this->item('JERSEY 30/1 ALGODON TRUZA 90 AZULINO'));
$row->create($this->item('JERSEY 30/1 ALGODON TRUZA 90 BOTELLA'));
$row->create($this->item('JERSEY 30/1 ALGODON TRUZA 90 GUINDA'));
$row->create($this->item('JERSEY 30/1 LAGODON 90 PERICO'));
 
$row->create($this->item('JERSEY 30/1 POLYALGODON 90 LILA CLARO'));
$row->create($this->item('JERSEY 30/1 POLYALGODON 90 LIMON BB'));
 
$row->create($this->item('JERSEY 30/1 POLYALGODON 93 ROSADO'));
$row->create($this->item('JERSEY 30/1 POLYALGODON 93 VERDE AGUA'));
$row->create($this->item('JERSEY 30/1 POLYALGODON TRUZA 90 BLANCO'));
$row->create($this->item('JERSEY 30/1 POLYALGODON TRUZA 90 CIELO'));
$row->create($this->item('JERSEY 30/1 POLYALGODON TRUZA 90 PLATA'));
$row->create($this->item('JERSEY LABRADO 30/1 ALGODON 80 BLANCO'));
$row->create($this->item('JERSEY LABRADO 30/1 ALGODON 80 CELESTE'));
$row->create($this->item('JERSEY LISTADO 30/1 ALGODON 80 ITALIANO'));
$row->create($this->item('JERSEY LISTADO 30/1 ALGODON 80 MARINO'));
$row->create($this->item('JERSEY LISTADO 30/1 ALGODON 80 MELANGE 10'));
 
$row->create($this->item('JERSEY PEINADO 30/1 ALGODON 90 VERDE AGUA'));
$row->create($this->item('JERSING LISTADO 30/1 ALGODON 75 CELESTE'));
$row->create($this->item('JERSING LISTADO 30/1 ALGODON 75 LIMON BB'));
$row->create($this->item('JERSING LISTADO 30/1 ALGODON 75 PATO'));
$row->create($this->item('JERSING LISTADO 30/1 ALGODON 75 ROSADO'));
$row->create($this->item('JERSING LISTADO 30/1 ALGODON 75 VERDE AGUA'));
$row->create($this->item('NIDO DE ABEJA 30/1 ALGODON 80 BLANCO'));
$row->create($this->item('NIDO DE ABEJA 30/1 ALGODON 80 CELESTE'));
$row->create($this->item('NIDO DE ABEJA 30/1 ALGODON 80 PATO'));
$row->create($this->item('NIDO DE ABEJA 30/1 ALGODON 80 ROSADO'));
$row->create($this->item('NIDO DE ABEJA 30/1 ALGODON 80 VERDE AGUA'));
$row->create($this->item('PIQUE 24/1 ALGODON 1.05 BLANCO'));
$row->create($this->item('PIQUE 24/1 ALGODON 90 PERICO'));
$row->create($this->item('RIB 150/2 PES ROJO'));
$row->create($this->item('RIB 150/2 POLYALGODON 85 ROJO'));
$row->create($this->item('RIB 20/1 ALGODON 80 ACERO'));
$row->create($this->item('RIB 20/1 ALGODON 80 ARENA'));
$row->create($this->item('RIB 20/1 ALGODON 80 AZULINO'));
 
$row->create($this->item('RIB 20/1 ALGODON 80 ROSADO'));
$row->create($this->item('RIB 20/1 ALGODON 80 SALESIANO'));
$row->create($this->item('RIB 20/1 ALGODON 80 SOMBRA'));
$row->create($this->item('RIB 20/1 ALGODON 80 TURQUEZA'));
$row->create($this->item('RIB 20/1 ALGODON 80 TURQUEZA MEDIO'));
$row->create($this->item('RIB 20/1 POLYALGODON 80 BLANCO'));
$row->create($this->item('RIB 24/1 ALGODON 80 MARINO'));
$row->create($this->item('RIB 24/1 ALGODON 80 MELANGE 10%'));
$row->create($this->item('RIB 30/1 ALG LYC 78 BLANCO'));
$row->create($this->item('RIB 30/1 ALG LYC 78 CELESTE'));
$row->create($this->item('RIB 30/1 ALG LYC 78 PATO'));
$row->create($this->item('RIB 30/1 ALG LYC 78 VERDE AGUA'));
$row->create($this->item('RIB 30/1 ALGODON 80'));
$row->create($this->item('RIB 30/1 ALGODON 80  MILITAR'));
$row->create($this->item('RIB 30/1 ALGODON 80 ACERO'));
$row->create($this->item('RIB 30/1 ALGODON 80 ACERO BLUE'));
 
$row->create($this->item('RIB 30/1 ALGODON 80 JADE'));
$row->create($this->item('RIB 30/1 ALGODON 80 KORAL'));
 
$row->create($this->item('RIB 30/1 ALGODON 80 TURQUEZA MEDIO'));
$row->create($this->item('RIB 30/1 ALGODON 80 VERDE AGUA'));
$row->create($this->item('RIB 30/1 ALGODON 80 VERDE OLIVO'));
$row->create($this->item('RIB 30/1 ALGODON LYCRADO 78 ARENA'));
$row->create($this->item('RIB 30/1 ALGODON LYCRADO 78 AZULINO'));
$row->create($this->item('RIB 30/1 ALGODON LYCRADO 78 CONCHO DE VINO'));
$row->create($this->item('RIB 30/1 ALGODON LYCRADO 78 TURQUEZA MEDIO'));
$row->create($this->item('RIB 30/1 ALGODON LYCTADO 78 ROSADO'));
$row->create($this->item('RIB 30/1 POLYALGODON 80 BLANCO'));

$row->create($this->item('RIB 30/1 POLYALGODON 80 PATO'));
$row->create($this->item('RIB 30/1 POLYALGODON 80 ROSADO'));
$row->create($this->item('RIB 30/1 POLYALGODON 80 ROSADO BB'));
$row->create($this->item('RIB 30/1 POLYALGODON 80 VERDE AGUA'));
$row->create($this->item('RIB 30/1ALGODON 80 ACERO'));
$row->create($this->item('RIB ACANALADO 2X1 30/1 ALGODON 60 BLANCO'));
$row->create($this->item('RIB PEINADO 30/1 ALGODON 80 BLANCO'));
$row->create($this->item('RIB PEINADO 30/1 ALGODON 80 ROJO'));
$row->create($this->item('RIB PEINADO 30/1 ALGODON ARENA'));
$row->create($this->item('SERVICIO'));
$row->create($this->item('STRECH 24/1 ALGODON 83'));
$row->create($this->item('STRECH 24/1 ALGODON 83 ACERO'));
$row->create($this->item('STRECH 24/1 ALGODON 83 ARENA'));
$row->create($this->item('STRECH 24/1 ALGODON 83 AZULINO'));
$row->create($this->item('STRECH 24/1 ALGODON 83 BARNIE'));
 
$row->create($this->item('STRECH 24/1 ALGODON 83 ORO'));
$row->create($this->item('STRECH 24/1 ALGODON 83 PALO ROSA'));
$row->create($this->item('STRECH 24/1 ALGODON 83 PATO'));
$row->create($this->item('STRECH 24/1 ALGODON 83 PERICO'));
$row->create($this->item('STRECH 24/1 POLYALGODON 83 ORO'));
$row->create($this->item('STRECH 24/1 POLYALGODON 83 ORO BRASIL'));
 
$row->create($this->item('STRECH 24/1 POLYALGODON 83 VERDE AGUA'));
$row->create($this->item('WAFFER 30/1 ALGODON 78 CELESTE'));
$row->create($this->item('WAFFER 30/1 ALGODON 78 LIMON BB'));
$row->create($this->item('WAFFER 30/1 ALGODON 78 PATO'));
$row->create($this->item('WAFFER 30/1 ALGODON 78 ROSADO'));
$row->create($this->item('WAFFER 30/1 ALGODON 78 VERDE AGUA'));



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
