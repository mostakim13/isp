<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            Brand::create([
                'name' => $facker->name,
            ]);
        }
    }
}
