<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $facker->name,
                'product_category_id' =>  $facker->biasedNumberBetween(0, 10),
                'unit_id' =>  $facker->biasedNumberBetween(0, 10),
                'purchases_price' => $facker->biasedNumberBetween(2000, 50000),
                'sale_price' => $facker->biasedNumberBetween(2000, 50000),
            ]);
        }
    }
}
