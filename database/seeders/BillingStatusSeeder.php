<?php

namespace Database\Seeders;

use App\Models\BillingStatus;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BillingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillingStatus::create([
            'name' => "Left",
        ]);
        BillingStatus::create([
            'name' => "Free",
        ]);
        BillingStatus::create([
            'name' => "Personal",
        ]);
        BillingStatus::create([
            'name' => "Inactive",
        ]);
        BillingStatus::create([
            'name' => "Active",
        ]);
    }
}
