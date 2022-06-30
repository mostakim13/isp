<?php

namespace Database\Seeders;

use App\Models\ClientType;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientType::create([
            'name' => "Corporate User",
            'company_id' => Company::first()->id,
            'details' => "Different Type Of Office like: Bank, Bima, Group, Somity, Agent,Dealership etc.",
        ]);
        ClientType::create([
            'name' => "Home User",
            'company_id' => Company::first()->id,
            'details' => "Different Type Of Home like: Varatiya, Sthaniyo etc.",
        ]);
    }
}
