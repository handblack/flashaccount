<?php

namespace Database\Factories;

use App\Models\WhBpartner;
use App\Models\WhCOrder;
use App\Models\WhDocType;
use App\Models\WhSequence;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WhBIncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        //Seria y Nro -------------------------------------------------------------------------------
        $dti = WhDocType::whereIn('shortname',['BIN'])->get('id')->toArray();
        $sid = WhSequence::whereIn('doctype_id',$dti)->get()->toArray();
        $sid = $this->faker->randomElement($sid);
        $sequence = WhSequence::where('id',$sid)->first();
        $seq_nro = $sequence->set_lastnumber($sequence->id);  
        // Socio de Negocio ---------------------------------------
        //$bp = WhBpartner::where('typeperson','C')->get('id');
        $bp = WhCOrder::select('bpartner_id')->distinct()->get();
        $bp = Arr::flatten($bp->toArray());
        $bp_id = $this->faker->randomElement($bp);
        // amount -------------------------------------------------
        $amt = $this->faker->numberBetween($min=1000,$max=8000);
        return [
            'datetrx'     => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
            'doctype_id'  =>  $sequence->doctype_id,
            'bankaccount_id' => 1,
            'sequence_id' => $sequence->id,
            'sequenceserial' => $sequence->serial,
            'sequenceno'  => $seq_nro,
            'currency_id' => 1,
            'bpartner_id' => $bp_id,
            'amount'      => $amt,
            'amountanticipation' => $amt,
            'amountopen'  => $amt, 
            'token'       => Str::random(50),
        ];
    }
}
