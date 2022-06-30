<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            Unit::create([
                'name' => $facker->name,
            ]);
        }
    }
}
