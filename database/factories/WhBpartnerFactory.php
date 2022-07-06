<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WhBpartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tp = $this->faker->randomElement(['C','P']);
        $lp = $this->faker->randomElement(['N','J']);
        $dn = ($lp =='N') ? '10' :'20';
        $dn .= $this->faker->numberBetween($min = 1000, $max = 9000);
        $dn .= $this->faker->numberBetween($min = 1000, $max = 9000);
        $dn .= $this->faker->numberBetween($min = 0, $max = 9);
        $bc = $tp . $dn;
        $ap = '';
        $am = '';
        $nom = '';
        $bpn = '';
        if($lp=='J'){
            $bpn = strtoupper($this->faker->company);

        }else{
            $ap = $this->faker->firstName($gender = null);
            $am = $this->faker->lastName();
            $nom = $this->faker->firstNameFemale();
            $bpn = strtoupper ($ap.' '.$am.', '.$nom);
        }
 
        $token = Str::random(10);
        return [
            'typeperson'   => $tp,
            'legalperson'  => $lp,
            'bpartnercode' => $bc,
            'doctype_id'   => 1,
            'documentno'   => $dn,
            'bpartnername' => $bpn,
            'lastname' => strtoupper($ap),
            'firstname' => strtoupper($am),
            'prename' => strtoupper($nom),
            'token' => $token,
        ];
    }
}
