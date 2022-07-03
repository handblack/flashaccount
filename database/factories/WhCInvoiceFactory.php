<?php

namespace Database\Factories;

use App\Models\WhBpartner;
use App\Models\WhCInvoice;
use App\Models\WhCurrency;
use App\Models\WhDocType;
use App\Models\WhSequence;
use App\Models\WhWarehouse;
use Faker\Factory as Faker;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Factories\Factory;

class WhCInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        //Seria y Nro -------------------------------------------------------------------------------
        $dti = WhDocType::whereIn('shortname',['FAC'])->get('id')->toArray();
        $sid = WhSequence::whereIn('doctype_id',$dti)->get()->toArray();
        $sid = $faker->randomElement($sid);
        $sequence = WhSequence::where('id',$sid)->first();
        $seq_nro = $sequence->set_lastnumber($sequence->id);        
        // Token -------------------------------------------------------------------------------
        //$hash = new Hashids('miasoftware');
        //var_dump($sequence->serial.$seq_nro);
        $token = md5($sequence->serial.$seq_nro);         
        // importes -------------------------------------------------------------------------------
        $amount = $faker->randomFloat(2,200,90000);
        return [
            'period' => date("Ym"), 
            'dateinvoiced' => $faker->dateTime(), 
            'doctype_id'   => $sequence->doctype->id,
            'bpartner_id'  => $faker->randomElement(WhBpartner::where('bpartnercode','LIKE','C%')->get()->toArray())['id'],
            'currency_id'  => $faker->randomElement(WhCurrency::get()->toArray())['id'],          
            'warehouse_id' => $faker->randomElement(WhWarehouse::get()->toArray())['id'],          
            'sequence_id'  => $sequence->id,
            'serial'       => $sequence->serial,
            'documentno'   => $seq_nro,
            'amountgrand'  => $amount,
            'amountopen'   => $amount,
            'token'        => $token,
        ];
    }
}
