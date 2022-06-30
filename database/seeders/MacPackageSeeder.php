<?php

namespace Database\Seeders;

use App\Models\MacPackage;
use Illuminate\Database\Seeder;

class MacPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 2; $i < 10; $i++) {
            MacPackage::create([
                'name' => $i . "MB",
                'bandwidth_md' => $i,
            ]);
        }
    }
}
