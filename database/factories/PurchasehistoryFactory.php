<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchasehistory;
use Faker\Generator as Faker;

class PurchasehistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->numberBetween($min=1000, $max=20000);
        
        return [
            'id' => rand(1,5),
            'product_name' => $this->faker->randomElement(['アウター','トップス','Tシャツ'.'ボトムス','ジーンズ']),
            'price' => $price,
            'purchase_date' => $this->faker->date(),
        ];
    }
}
