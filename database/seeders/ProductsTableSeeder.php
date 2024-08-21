<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('products')->insert([
        ['name' => 'Cumi Tepung', 'price' => 15000],
        ['name' => 'Cah Taoge', 'price' => 10000],
        ['name' => 'Es Jeruk Nipis', 'price' => 10000],
        ['name' => 'Es Kelapa', 'price' => 10000],
        ['name' => 'Teh Tarik', 'price' => 5000],

    ]);
}
}
