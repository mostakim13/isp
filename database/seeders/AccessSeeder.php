<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GroupAccess;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupAccess::insert([
            "group_id"      => "1",
            "group_access"  => '["dashboard","user_list","user_create","user_update","user_delete","user_access","group_list","group_update","group_delete","group_access"]'
        ]);
    }
}
