<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            ProductCategory::create([
                'name' => $facker->name,
            ]);
        }
    }
}
