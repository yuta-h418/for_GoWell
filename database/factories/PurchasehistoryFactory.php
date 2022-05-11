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
            'customer_id' => rand(1,5),
            'product_name' => $this->faker->randomElement(['アウター','トップス','Tシャツ','ボトムス','ジーンズ']),
            'product_kind' => $this->faker->randomElement(['1','2','3','4','5','6']),
            'price' => $price,
            'cash_kind' => $this->faker->randomElement(['1','2','3','4','5','6']),
            'purchase_date' => $this->faker->date(),
        ];
    }
}
