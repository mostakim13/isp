<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Protocol;
use Illuminate\Database\Seeder;

class ProtocolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Protocol::create([
            'name' => "Static",
            'company_id' => Company::first()->id,

        ]);
        Protocol::create([
            'name' => "Hotspot",
            'company_id' => Company::first()->id,
        ]);
        Protocol::create([
            'name' => "PPPOE",
            'company_id' => Company::first()->id,
        ]);
    }
}
