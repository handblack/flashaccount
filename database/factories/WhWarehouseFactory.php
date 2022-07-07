<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WhWarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $code = $this->faker->numberBetween($min = 10, $max = 90);
        $whco = Str::random(2) . $code;
        return [
            'warehousename' => strtoupper($this->faker->streetName),
            'shortname' => strtoupper($whco),
            'isactive' => $this->faker->randomElement(['Y','N']),
            'token' => Str::random(10),
        ];
    }
}
