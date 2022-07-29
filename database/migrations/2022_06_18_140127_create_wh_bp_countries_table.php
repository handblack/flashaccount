<?php

use App\Models\WhBpCountry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBpCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bp_countries', function (Blueprint $table) {
            $table->id();
            $table->string('countryname',40);
            $table->string('alfa2',2)->nullable();
            $table->string('alfa3',3)->nullable();
            $table->string('shortname',5)->nullable(); // ISO 3166-1
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->timestamps();
        });
        $row = new WhBpCountry();
        $row->create(['alfa2' => 'PE', 'alfa3' => 'PER', 'countryname' => 'PERU']);
        $row->create(['alfa2' => 'CL', 'alfa3' => 'CHL', 'countryname' => 'CHILE']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bp_countries');
    }
}
