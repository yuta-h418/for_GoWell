<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
            [
                'customer_id'=> '1',
                'name'=> '鈴木太郎',
                'tell_number'=> '08011112222',
                'birthday'=> '1990/01/20',
                'regist_date'=> date('Y-m-d'),
            ],
            [
                'customer_id'=> '2',
                'name'=> '田中太郎',
                'tell_number'=> '08033334444',
                'birthday'=> '1991/02/20',
                'regist_date'=> date('Y-m-d'),
            ],
            [
                'customer_id'=> '3',
                'name'=> '林太郎',
                'tell_number'=> '08055556666',
                'birthday'=> '1992/03/20',
                'regist_date'=> date('Y-m-d'),
            ],
            [
                'customer_id'=> '4',
                'name'=> '村田太郎',
                'tell_number'=> '08077778888',
                'birthday'=> '1993/04/20',
                'regist_date'=> date('Y-m-d'),
            ],
            [
                'customer_id'=> '5',
                'name'=> '上原太郎',
                'tell_number'=> '08099991111',
                'birthday'=> '1994/05/20',
                'regist_date'=> date('Y-m-d'),
            ],

        ]);
    }
}
