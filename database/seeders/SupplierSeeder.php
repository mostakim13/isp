<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        for ($i = 0; $i < 10; $i++) {
            Supplier::create([
                'name' => $facker->name,
                'company_id' => 1,
                'phone' => $facker->phoneNumber,
                'email' => $facker->email,
                'address' => $facker->address,
            ]);
        }
    }
}
