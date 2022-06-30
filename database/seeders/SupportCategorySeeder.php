<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\SupportCategory;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class SupportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            SupportCategory::create([
                'name' => $facker->name,
            ]);
        }
    }
}
