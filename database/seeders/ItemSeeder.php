<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value[] = [
            'item_id' => '001',
            'name' => 'IIG',
            'unit' => '1',
            'vat' => '2',

        ];
        $value[] = [
            'item_id' => '002',
            'name' => 'BDIX1',
            'unit' => '2',
            'vat' => '3',
        ];
        $value[] = [
            'item_id' => '003',
            'name' => 'BDIX2',
            'unit' => '3',
            'vat' => '4',

        ];

        Item::insert($value);
    }
}
