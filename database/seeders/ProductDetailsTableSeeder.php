<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_details')->insert([
            [
                'product_no'=> '1',
                'product_kind'=> '食品',
            ],
            [
                'product_no'=> '2',
                'product_kind'=> '日用品',
            ],
            [
                'product_no'=> '3',
                'product_kind'=> '衣服',
            ],
            [
                'product_no'=> '4',
                'product_kind'=> '本',
            ],
            [
                'product_no'=> '5',
                'product_kind'=> '交際費',
            ],
            [
                'product_no'=> '6',
                'product_kind'=> 'チャージ',
            ],

        ]);
    
    }
}
