<?php

use App\Models\WhBpState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpartner_country_id');
            $table->string('statename',50);
            $table->string('shortname',20)->nullable();
            $table->string('statecode',10)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhBpState();
        $row->create(['bpartner_country_id' => 1,'statecode' => '01','statename' => 'AMAZONAS']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '02','statename' => 'ÁNCASH']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '03','statename' => 'APURÍMAC']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '04','statename' => 'AREQUIPA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '05','statename' => 'AYACUCHO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '06','statename' => 'CAJAMARCA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '07','statename' => 'CALLAO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '08','statename' => 'CUSCO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '09','statename' => 'HUANCAVELICA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '10','statename' => 'HUÁNUCO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '11','statename' => 'ICA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '12','statename' => 'JUNÍN']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '13','statename' => 'LA LIBERTAD']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '14','statename' => 'LAMBAYEQUE']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '15','statename' => 'LIMA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '16','statename' => 'LORETO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '17','statename' => 'MADRE DE DIOS']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '18','statename' => 'MOQUEGUA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '19','statename' => 'PASCO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '20','statename' => 'PIURA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '21','statename' => 'PUNO']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '22','statename' => 'SAN MARTÍN']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '23','statename' => 'TACNA']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '24','statename' => 'TUMBES']);
        $row->create(['bpartner_country_id' => 1,'statecode' => '25','statename' => 'UCAYALI']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bp_states');
    }
}
