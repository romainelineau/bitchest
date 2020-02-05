<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'name' => 'Bitcoin',
                'initials' => 'BTC'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Ethereum',
                'initials' => 'ETH'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Ripple',
                'initials' => 'XRP'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Bitcoin Cash',
                'initials' => 'BCH'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Cardano',
                'initials' => 'ADA'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Litecoin',
                'initials' => 'LTC'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'NEM',
                'initials' => 'XEM'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Stellar',
                'initials' => 'XLM'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'IOTA',
                'initials' => 'MIOTA'
            ]
        ]);
        DB::table('currencies')->insert([
            [
                'name' => 'Dash',
                'initials' => 'DASH'
            ]
        ]);
    }
}
