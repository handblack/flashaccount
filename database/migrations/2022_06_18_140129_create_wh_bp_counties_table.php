<?php

use App\Models\WhBpCounty;
use App\Models\WhBpState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_counties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpartner_state_id');
            $table->string('countyname',50);
            $table->string('shortname',20)->nullable();
            $table->string('countycode',10)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhBpCounty();
        $provincias[] = ['a' => '01', 'b'=>'0101', 'c'=>'CHACHAPOYAS'];
        $provincias[] = ['a' => '01', 'b'=>'0102', 'c'=>'BAGUA'];
        $provincias[] = ['a' => '01', 'b'=>'0103', 'c'=>'BONGARÁ'];
        $provincias[] = ['a' => '01', 'b'=>'0104', 'c'=>'CONDORCANQUI'];
        $provincias[] = ['a' => '01', 'b'=>'0105', 'c'=>'LUYA'];
        $provincias[] = ['a' => '01', 'b'=>'0106', 'c'=>'RODRÍGUEZ DE MENDOZA'];
        $provincias[] = ['a' => '01', 'b'=>'0107', 'c'=>'UTCUBAMBA'];
        $provincias[] = ['a' => '02', 'b'=>'0201', 'c'=>'HUARAZ'];
        $provincias[] = ['a' => '02', 'b'=>'0202', 'c'=>'AIJA'];
        $provincias[] = ['a' => '02', 'b'=>'0203', 'c'=>'ANTONIO RAYMONDI'];
        $provincias[] = ['a' => '02', 'b'=>'0204', 'c'=>'ASUNCIÓN'];
        $provincias[] = ['a' => '02', 'b'=>'0205', 'c'=>'BOLOGNESI'];
        $provincias[] = ['a' => '02', 'b'=>'0206', 'c'=>'CARHUAZ'];
        $provincias[] = ['a' => '02', 'b'=>'0207', 'c'=>'CARLOS FERMÍN FITZCARRALD'];
        $provincias[] = ['a' => '02', 'b'=>'0208', 'c'=>'CASMA'];
        $provincias[] = ['a' => '02', 'b'=>'0209', 'c'=>'CORONGO'];
        $provincias[] = ['a' => '02', 'b'=>'0210', 'c'=>'HUARI'];
        $provincias[] = ['a' => '02', 'b'=>'0211', 'c'=>'HUARMEY'];
        $provincias[] = ['a' => '02', 'b'=>'0212', 'c'=>'HUAYLAS'];
        $provincias[] = ['a' => '02', 'b'=>'0213', 'c'=>'MARISCAL LUZURIAGA'];
        $provincias[] = ['a' => '02', 'b'=>'0214', 'c'=>'OCROS'];
        $provincias[] = ['a' => '02', 'b'=>'0215', 'c'=>'PALLASCA'];
        $provincias[] = ['a' => '02', 'b'=>'0216', 'c'=>'POMABAMBA'];
        $provincias[] = ['a' => '02', 'b'=>'0217', 'c'=>'RECUAY'];
        $provincias[] = ['a' => '02', 'b'=>'0218', 'c'=>'SANTA'];
        $provincias[] = ['a' => '02', 'b'=>'0219', 'c'=>'SIHUAS'];
        $provincias[] = ['a' => '02', 'b'=>'0220', 'c'=>'YUNGAY'];
        $provincias[] = ['a' => '03', 'b'=>'0301', 'c'=>'ABANCAY'];
        $provincias[] = ['a' => '03', 'b'=>'0302', 'c'=>'ANDAHUAYLAS'];
        $provincias[] = ['a' => '03', 'b'=>'0303', 'c'=>'ANTABAMBA'];
        $provincias[] = ['a' => '03', 'b'=>'0304', 'c'=>'AYMARAES'];
        $provincias[] = ['a' => '03', 'b'=>'0305', 'c'=>'COTABAMBAS'];
        $provincias[] = ['a' => '03', 'b'=>'0306', 'c'=>'CHINCHEROS'];
        $provincias[] = ['a' => '03', 'b'=>'0307', 'c'=>'GRAU'];
        $provincias[] = ['a' => '04', 'b'=>'0401', 'c'=>'AREQUIPA'];
        $provincias[] = ['a' => '04', 'b'=>'0402', 'c'=>'CAMANÁ'];
        $provincias[] = ['a' => '04', 'b'=>'0403', 'c'=>'CARAVELÍ'];
        $provincias[] = ['a' => '04', 'b'=>'0404', 'c'=>'CASTILLA'];
        $provincias[] = ['a' => '04', 'b'=>'0405', 'c'=>'CAYLLOMA'];
        $provincias[] = ['a' => '04', 'b'=>'0406', 'c'=>'CONDESUYOS'];
        $provincias[] = ['a' => '04', 'b'=>'0407', 'c'=>'ISLAY'];
        $provincias[] = ['a' => '04', 'b'=>'0408', 'c'=>'LA UNIÒN'];
        $provincias[] = ['a' => '05', 'b'=>'0501', 'c'=>'HUAMANGA'];
        $provincias[] = ['a' => '05', 'b'=>'0502', 'c'=>'CANGALLO'];
        $provincias[] = ['a' => '05', 'b'=>'0503', 'c'=>'HUANCA SANCOS'];
        $provincias[] = ['a' => '05', 'b'=>'0504', 'c'=>'HUANTA'];
        $provincias[] = ['a' => '05', 'b'=>'0505', 'c'=>'LA MAR'];
        $provincias[] = ['a' => '05', 'b'=>'0506', 'c'=>'LUCANAS'];
        $provincias[] = ['a' => '05', 'b'=>'0507', 'c'=>'PARINACOCHAS'];
        $provincias[] = ['a' => '05', 'b'=>'0508', 'c'=>'PÀUCAR DEL SARA SARA'];
        $provincias[] = ['a' => '05', 'b'=>'0509', 'c'=>'SUCRE'];
        $provincias[] = ['a' => '05', 'b'=>'0510', 'c'=>'VÍCTOR FAJARDO'];
        $provincias[] = ['a' => '05', 'b'=>'0511', 'c'=>'VILCAS HUAMÁN'];
        $provincias[] = ['a' => '06', 'b'=>'0601', 'c'=>'CAJAMARCA'];
        $provincias[] = ['a' => '06', 'b'=>'0602', 'c'=>'CAJABAMBA'];
        $provincias[] = ['a' => '06', 'b'=>'0603', 'c'=>'CELENDÍN'];
        $provincias[] = ['a' => '06', 'b'=>'0604', 'c'=>'CHOTA'];
        $provincias[] = ['a' => '06', 'b'=>'0605', 'c'=>'CONTUMAZÁ'];
        $provincias[] = ['a' => '06', 'b'=>'0606', 'c'=>'CUTERVO'];
        $provincias[] = ['a' => '06', 'b'=>'0607', 'c'=>'HUALGAYOC'];
        $provincias[] = ['a' => '06', 'b'=>'0608', 'c'=>'JAÉN'];
        $provincias[] = ['a' => '06', 'b'=>'0609', 'c'=>'SAN IGNACIO'];
        $provincias[] = ['a' => '06', 'b'=>'0610', 'c'=>'SAN MARCOS'];
        $provincias[] = ['a' => '06', 'b'=>'0611', 'c'=>'SAN MIGUEL'];
        $provincias[] = ['a' => '06', 'b'=>'0612', 'c'=>'SAN PABLO'];
        $provincias[] = ['a' => '06', 'b'=>'0613', 'c'=>'SANTA CRUZ'];
        $provincias[] = ['a' => '07', 'b'=>'0701', 'c'=>'PROV. CONST. DEL CALLAO'];
        $provincias[] = ['a' => '08', 'b'=>'0801', 'c'=>'CUSCO'];
        $provincias[] = ['a' => '08', 'b'=>'0802', 'c'=>'ACOMAYO'];
        $provincias[] = ['a' => '08', 'b'=>'0803', 'c'=>'ANTA'];
        $provincias[] = ['a' => '08', 'b'=>'0804', 'c'=>'CALCA'];
        $provincias[] = ['a' => '08', 'b'=>'0805', 'c'=>'CANAS'];
        $provincias[] = ['a' => '08', 'b'=>'0806', 'c'=>'CANCHIS'];
        $provincias[] = ['a' => '08', 'b'=>'0807', 'c'=>'CHUMBIVILCAS'];
        $provincias[] = ['a' => '08', 'b'=>'0808', 'c'=>'ESPINAR'];
        $provincias[] = ['a' => '08', 'b'=>'0809', 'c'=>'LA CONVENCIÓN'];
        $provincias[] = ['a' => '08', 'b'=>'0810', 'c'=>'PARURO'];
        $provincias[] = ['a' => '08', 'b'=>'0811', 'c'=>'PAUCARTAMBO'];
        $provincias[] = ['a' => '08', 'b'=>'0812', 'c'=>'QUISPICANCHI'];
        $provincias[] = ['a' => '08', 'b'=>'0813', 'c'=>'URUBAMBA'];
        $provincias[] = ['a' => '09', 'b'=>'0901', 'c'=>'HUANCAVELICA'];
        $provincias[] = ['a' => '09', 'b'=>'0902', 'c'=>'ACOBAMBA'];
        $provincias[] = ['a' => '09', 'b'=>'0903', 'c'=>'ANGARAES'];
        $provincias[] = ['a' => '09', 'b'=>'0904', 'c'=>'CASTROVIRREYNA'];
        $provincias[] = ['a' => '09', 'b'=>'0905', 'c'=>'CHURCAMPA'];
        $provincias[] = ['a' => '09', 'b'=>'0906', 'c'=>'HUAYTARÁ'];
        $provincias[] = ['a' => '09', 'b'=>'0907', 'c'=>'TAYACAJA'];
        $provincias[] = ['a' => '10', 'b'=>'1001', 'c'=>'HUÁNUCO'];
        $provincias[] = ['a' => '10', 'b'=>'1002', 'c'=>'AMBO'];
        $provincias[] = ['a' => '10', 'b'=>'1003', 'c'=>'DOS DE MAYO'];
        $provincias[] = ['a' => '10', 'b'=>'1004', 'c'=>'HUACAYBAMBA'];
        $provincias[] = ['a' => '10', 'b'=>'1005', 'c'=>'HUAMALÍES'];
        $provincias[] = ['a' => '10', 'b'=>'1006', 'c'=>'LEONCIO PRADO'];
        $provincias[] = ['a' => '10', 'b'=>'1007', 'c'=>'MARAÑÓN'];
        $provincias[] = ['a' => '10', 'b'=>'1008', 'c'=>'PACHITEA'];
        $provincias[] = ['a' => '10', 'b'=>'1009', 'c'=>'PUERTO INCA'];
        $provincias[] = ['a' => '10', 'b'=>'1010', 'c'=>'LAURICOCHA '];
        $provincias[] = ['a' => '10', 'b'=>'1011', 'c'=>'YAROWILCA '];
        $provincias[] = ['a' => '11', 'b'=>'1101', 'c'=>'ICA '];
        $provincias[] = ['a' => '11', 'b'=>'1102', 'c'=>'CHINCHA '];
        $provincias[] = ['a' => '11', 'b'=>'1103', 'c'=>'NASCA '];
        $provincias[] = ['a' => '11', 'b'=>'1104', 'c'=>'PALPA '];
        $provincias[] = ['a' => '11', 'b'=>'1105', 'c'=>'PISCO '];
        $provincias[] = ['a' => '12', 'b'=>'1201', 'c'=>'HUANCAYO '];
        $provincias[] = ['a' => '12', 'b'=>'1202', 'c'=>'CONCEPCIÓN '];
        $provincias[] = ['a' => '12', 'b'=>'1203', 'c'=>'CHANCHAMAYO '];
        $provincias[] = ['a' => '12', 'b'=>'1204', 'c'=>'JAUJA '];
        $provincias[] = ['a' => '12', 'b'=>'1205', 'c'=>'JUNÍN '];
        $provincias[] = ['a' => '12', 'b'=>'1206', 'c'=>'SATIPO '];
        $provincias[] = ['a' => '12', 'b'=>'1207', 'c'=>'TARMA '];
        $provincias[] = ['a' => '12', 'b'=>'1208', 'c'=>'YAULI '];
        $provincias[] = ['a' => '12', 'b'=>'1209', 'c'=>'CHUPACA '];
        $provincias[] = ['a' => '13', 'b'=>'1301', 'c'=>'TRUJILLO '];
        $provincias[] = ['a' => '13', 'b'=>'1302', 'c'=>'ASCOPE '];
        $provincias[] = ['a' => '13', 'b'=>'1303', 'c'=>'BOLÍVAR '];
        $provincias[] = ['a' => '13', 'b'=>'1304', 'c'=>'CHEPÉN '];
        $provincias[] = ['a' => '13', 'b'=>'1305', 'c'=>'JULCÁN '];
        $provincias[] = ['a' => '13', 'b'=>'1306', 'c'=>'OTUZCO '];
        $provincias[] = ['a' => '13', 'b'=>'1307', 'c'=>'PACASMAYO '];
        $provincias[] = ['a' => '13', 'b'=>'1308', 'c'=>'PATAZ '];
        $provincias[] = ['a' => '13', 'b'=>'1309', 'c'=>'SÁNCHEZ CARRIÓN '];
        $provincias[] = ['a' => '13', 'b'=>'1310', 'c'=>'SANTIAGO DE CHUCO '];
        $provincias[] = ['a' => '13', 'b'=>'1311', 'c'=>'GRAN CHIMÚ '];
        $provincias[] = ['a' => '13', 'b'=>'1312', 'c'=>'VIRÚ '];
        $provincias[] = ['a' => '14', 'b'=>'1401', 'c'=>'CHICLAYO '];
        $provincias[] = ['a' => '14', 'b'=>'1402', 'c'=>'FERREÑAFE '];
        $provincias[] = ['a' => '14', 'b'=>'1403', 'c'=>'LAMBAYEQUE '];
        $provincias[] = ['a' => '15', 'b'=>'1501', 'c'=>'LIMA '];
        $provincias[] = ['a' => '15', 'b'=>'1502', 'c'=>'BARRANCA '];
        $provincias[] = ['a' => '15', 'b'=>'1503', 'c'=>'CAJATAMBO '];
        $provincias[] = ['a' => '15', 'b'=>'1504', 'c'=>'CANTA '];
        $provincias[] = ['a' => '15', 'b'=>'1505', 'c'=>'CAÑETE '];
        $provincias[] = ['a' => '15', 'b'=>'1506', 'c'=>'HUARAL '];
        $provincias[] = ['a' => '15', 'b'=>'1507', 'c'=>'HUAROCHIRÍ '];
        $provincias[] = ['a' => '15', 'b'=>'1508', 'c'=>'HUAURA '];
        $provincias[] = ['a' => '15', 'b'=>'1509', 'c'=>'OYÓN '];
        $provincias[] = ['a' => '15', 'b'=>'1510', 'c'=>'YAUYOS '];
        $provincias[] = ['a' => '16', 'b'=>'1601', 'c'=>'MAYNAS '];
        $provincias[] = ['a' => '16', 'b'=>'1602', 'c'=>'ALTO AMAZONAS '];
        $provincias[] = ['a' => '16', 'b'=>'1603', 'c'=>'LORETO '];
        $provincias[] = ['a' => '16', 'b'=>'1604', 'c'=>'MARISCAL RAMÓN CASTILLA '];
        $provincias[] = ['a' => '16', 'b'=>'1605', 'c'=>'REQUENA '];
        $provincias[] = ['a' => '16', 'b'=>'1606', 'c'=>'UCAYALI '];
        $provincias[] = ['a' => '16', 'b'=>'1607', 'c'=>'DATEM DEL MARAÑÓN '];
        $provincias[] = ['a' => '16', 'b'=>'1608', 'c'=>'PUTUMAYO'];
        $provincias[] = ['a' => '17', 'b'=>'1701', 'c'=>'TAMBOPATA '];
        $provincias[] = ['a' => '17', 'b'=>'1702', 'c'=>'MANU '];
        $provincias[] = ['a' => '17', 'b'=>'1703', 'c'=>'TAHUAMANU '];
        $provincias[] = ['a' => '18', 'b'=>'1801', 'c'=>'MARISCAL NIETO '];
        $provincias[] = ['a' => '18', 'b'=>'1802', 'c'=>'GENERAL SÁNCHEZ CERRO '];
        $provincias[] = ['a' => '18', 'b'=>'1803', 'c'=>'ILO '];
        $provincias[] = ['a' => '19', 'b'=>'1901', 'c'=>'PASCO '];
        $provincias[] = ['a' => '19', 'b'=>'1902', 'c'=>'DANIEL ALCIDES CARRIÓN '];
        $provincias[] = ['a' => '19', 'b'=>'1903', 'c'=>'OXAPAMPA '];
        $provincias[] = ['a' => '20', 'b'=>'2001', 'c'=>'PIURA '];
        $provincias[] = ['a' => '20', 'b'=>'2002', 'c'=>'AYABACA '];
        $provincias[] = ['a' => '20', 'b'=>'2003', 'c'=>'HUANCABAMBA '];
        $provincias[] = ['a' => '20', 'b'=>'2004', 'c'=>'MORROPÓN '];
        $provincias[] = ['a' => '20', 'b'=>'2005', 'c'=>'PAITA '];
        $provincias[] = ['a' => '20', 'b'=>'2006', 'c'=>'SULLANA '];
        $provincias[] = ['a' => '20', 'b'=>'2007', 'c'=>'TALARA '];
        $provincias[] = ['a' => '20', 'b'=>'2008', 'c'=>'SECHURA '];
        $provincias[] = ['a' => '21', 'b'=>'2101', 'c'=>'PUNO '];
        $provincias[] = ['a' => '21', 'b'=>'2102', 'c'=>'AZÁNGARO '];
        $provincias[] = ['a' => '21', 'b'=>'2103', 'c'=>'CARABAYA '];
        $provincias[] = ['a' => '21', 'b'=>'2104', 'c'=>'CHUCUITO '];
        $provincias[] = ['a' => '21', 'b'=>'2105', 'c'=>'EL COLLAO '];
        $provincias[] = ['a' => '21', 'b'=>'2106', 'c'=>'HUANCANÉ '];
        $provincias[] = ['a' => '21', 'b'=>'2107', 'c'=>'LAMPA '];
        $provincias[] = ['a' => '21', 'b'=>'2108', 'c'=>'MELGAR '];
        $provincias[] = ['a' => '21', 'b'=>'2109', 'c'=>'MOHO '];
        $provincias[] = ['a' => '21', 'b'=>'2110', 'c'=>'SAN ANTONIO DE PUTINA '];
        $provincias[] = ['a' => '21', 'b'=>'2111', 'c'=>'SAN ROMÁN '];
        $provincias[] = ['a' => '21', 'b'=>'2112', 'c'=>'SANDIA '];
        $provincias[] = ['a' => '21', 'b'=>'2113', 'c'=>'YUNGUYO '];
        $provincias[] = ['a' => '22', 'b'=>'2201', 'c'=>'MOYOBAMBA '];
        $provincias[] = ['a' => '22', 'b'=>'2202', 'c'=>'BELLAVISTA '];
        $provincias[] = ['a' => '22', 'b'=>'2203', 'c'=>'EL DORADO '];
        $provincias[] = ['a' => '22', 'b'=>'2204', 'c'=>'HUALLAGA '];
        $provincias[] = ['a' => '22', 'b'=>'2205', 'c'=>'LAMAS '];
        $provincias[] = ['a' => '22', 'b'=>'2206', 'c'=>'MARISCAL CÁCERES '];
        $provincias[] = ['a' => '22', 'b'=>'2207', 'c'=>'PICOTA '];
        $provincias[] = ['a' => '22', 'b'=>'2208', 'c'=>'RIOJA '];
        $provincias[] = ['a' => '22', 'b'=>'2209', 'c'=>'SAN MARTÍN '];
        $provincias[] = ['a' => '22', 'b'=>'2210', 'c'=>'TOCACHE '];
        $provincias[] = ['a' => '23', 'b'=>'2301', 'c'=>'TACNA '];
        $provincias[] = ['a' => '23', 'b'=>'2302', 'c'=>'CANDARAVE '];
        $provincias[] = ['a' => '23', 'b'=>'2303', 'c'=>'JORGE BASADRE '];
        $provincias[] = ['a' => '23', 'b'=>'2304', 'c'=>'TARATA '];
        $provincias[] = ['a' => '24', 'b'=>'2401', 'c'=>'TUMBES '];
        $provincias[] = ['a' => '24', 'b'=>'2402', 'c'=>'CONTRALMIRANTE VILLAR '];
        $provincias[] = ['a' => '24', 'b'=>'2403', 'c'=>'ZARUMILLA '];
        $provincias[] = ['a' => '25', 'b'=>'2501', 'c'=>'CORONEL PORTILLO '];
        $provincias[] = ['a' => '25', 'b'=>'2502', 'c'=>'ATALAYA '];
        $provincias[] = ['a' => '25', 'b'=>'2503', 'c'=>'PADRE ABAD '];
        $provincias[] = ['a' => '25', 'b'=>'2504', 'c'=>'PURÚS'];


        foreach($provincias as $p){
            $find = WhBpState::where('statecode',$p['a'])->first();
            $row->create([
                'bpartner_state_id' => $find->id,
                'countyname' => $p['c'],
                'countycode' => $p['b'],
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bp_counties');
    }
}
