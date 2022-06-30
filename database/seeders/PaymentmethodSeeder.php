<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class PaymentmethodSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(Facker $facker)
    {

        PaymentMethod::create([
            'name' => 'HandCash',
            'company_id' => Company::first()->id,
        ]);
    }
}
