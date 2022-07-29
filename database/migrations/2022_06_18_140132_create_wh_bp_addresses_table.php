<?php

use App\Models\WhBpAddress;
use App\Models\WhBpCity;
use App\Models\WhBpCountry;
use App\Models\WhBpCounty;
use App\Models\WhBpState;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpartner_id');
            $table->foreignId('bpartner_country_id')->nullable();
            $table->foreignId('bpartner_state_id')->nullable();
            $table->foreignId('bpartner_county_id')->nullable();
            $table->foreignId('bpartner_city_id')->nullable();
            $table->string('token',60)->nullable();
            $table->string('address',200)->nullable();
            $table->string('reference',100)->nullable();
            $table->string('shortname',50)->nullable();
            $table->string('ubigeo',8)->nullable();
            $table->string('zipcode',15)->nullable();
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $hash = new Hashids();
        $dis = WhBpCity::where('citycode','150110')->first();
        $pro = WhBpCounty::where('id',$dis->bpartner_county_id)->first();
        $dep = WhBpState::where('id',$pro->bpartner_state_id)->first();
        $pai = WhBpCountry::where('id',$dep->bpartner_country_id)->first();
        $row = new WhBpAddress();
        $row->bpartner_id = 1;
        $row->address = 'CALLE 13A NRO 180 Int. A-18 (C.C HIPER)';
        $row->bpartner_city_id    = $dis->id;
        $row->bpartner_county_id  = $pro->id; 
        $row->bpartner_state_id   = $dep->id; 
        $row->bpartner_country_id = $pai->id; 
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();

        $hash = new Hashids();
        $dis = WhBpCity::where('citycode','150130')->first();
        $pro = WhBpCounty::where('id',$dis->bpartner_county_id)->first();
        $dep = WhBpState::where('id',$pro->bpartner_state_id)->first();
        $pai = WhBpCountry::where('id',$dep->bpartner_country_id)->first();
        $row = new WhBpAddress();
        $row->bpartner_id = 1;
        $row->address = 'CALLE VIVALDI 131 - URB LAS MAGNOLIAS';
        $row->bpartner_city_id    = $dis->id;
        $row->bpartner_county_id  = $pro->id; 
        $row->bpartner_state_id   = $dep->id; 
        $row->bpartner_country_id = $pai->id; 
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bp_addresses');
    }
}
