<?php

namespace Database\Factories;

use App\Models\WhCOrder;
use App\Models\WhProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WhCOrderLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // order ID -------------------------------------------------
        $quantity = $this->faker->numberBetween($min=1,$max=200);
        $priceunit = $this->faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 13.20);
        $amtbase =  $quantity * $priceunit;
        // product --------------------------------------------------
        $pid = $this->faker->randomElement(Arr::flatten(WhProduct::get('id')->toArray()));
        $pname = WhProduct::find($pid)->productname;
        return [
            'typeproduct' => 'P',
            'typeoperation_id' => 7,
            'um_id' => 1,
            'tax_id' => 1,
            'order_id'    => $this->faker->randomElement(Arr::flatten(WhCOrder::get('id')->toArray())), 
            'product_id'  => $pid,
            'description' => $pname,
            'quantity'    => $quantity, 
            'priceunit'   => $priceunit, 
            'priceunittax' => round($priceunit * 1.18,2),
            'amountbase'  => $amtbase,
            'amountexo'   => 0,
            'amounttax'   => ($amtbase * 18) /100,
            'amountgrand' => $amtbase * 1.18,
            'token'       => Str::random(50),
        ];
    }
}
