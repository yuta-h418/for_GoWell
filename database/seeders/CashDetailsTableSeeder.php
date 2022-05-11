<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cash_details')->insert([
            [
                'cash_no'=> '1',
                'cash_kind'=> 'Cash',
            ],
            [
                'cash_no'=> '2',
                'cash_kind'=> 'RakutenCard',
            ],
            [
                'cash_no'=> '3',
                'cash_kind'=> 'LINECard',
            ],
            [
                'cash_no'=> '4',
                'cash_kind'=> 'ANACard',
            ],
            [
                'cash_no'=> '5',
                'cash_kind'=> 'PayPay',
            ],
            [
                'cash_no'=> '6',
                'cash_kind'=> 'Suica',
            ],
            
        ]);
    }
}
