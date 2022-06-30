<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'slug' => 'super-admin',
            'name' => 'Super Admin',
            'description' => 'Super Admin',
            'updated_at' => new DateTime(),
            'created_at' => new DateTime(),
        ]);
        DB::table('groups')->insert([
            'slug' => 'admin',
            'name' => 'Admin',
            'description' => 'Admin',
            'updated_at' => new DateTime(),
            'created_at' => new DateTime(),
        ]);
    }
}
