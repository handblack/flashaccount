<?php

namespace Database\Factories;

use App\Models\WhBpartner;
use App\Models\WhDocType;
use App\Models\WhSequence;
use App\Models\WhWarehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WhPOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Seria y Nro -------------------------------------------------------------------------------
        $dti = WhDocType::whereIn('shortname',['OCO'])->get('id')->toArray();
        $sid = WhSequence::whereIn('doctype_id',$dti)->get()->toArray();
        $sid = $this->faker->randomElement($sid);
        $sequence = WhSequence::where('id',$sid)->first();
        //dd($sequence);
        $seq_nro = $sequence->set_lastnumber($sequence->id);   
        // Socio de Negocio ---------------------------------------
        $bp = WhBpartner::where('typeperson','P')->get('id');
        $bp = Arr::flatten($bp->toArray());
        $bp_id = $this->faker->randomElement($bp);
        // Token -------------------------------------------------- 
        $token = Str::random(50);
        // warehouse ----------------------------------------------
        $whi = $this->faker->randomElement(Arr::flatten(WhWarehouse::where('isactive','Y')->get('id')->toArray())); 
        return [
            'dateorder'    => $this->faker->dateTime(), 
            'dateacct'     => date("Y-m-d"),
            'period'       => date("Ym"),
            'bpartner_id'  => $bp_id,
            'warehouse_id' => $whi,
            'currency_id'  => '1',
            'sequence_id'  => $sequence->id,
            'doctype_id'   => $sequence->doctype_id,
            'serial'       => $sequence->serial,
            'documentno'   => $seq_nro, 
            'token'        => $token, 
        ];
    }
}
