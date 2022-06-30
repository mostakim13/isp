<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Faker\Generator as Facker;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Facker $facker)
    {
        Account::create([
            'account_name' => "Hand Cash",
            'company_id' => 1,
            'amount' => 100000,
        ]);
        for ($i = 0; $i < 4; $i++) {
            Account::create([
                'account_name' => $facker->name,
                'company_id' => 1,
                'amount' => $facker->biasedNumberBetween(100000, 500000),
            ]);
        }
    }
}
