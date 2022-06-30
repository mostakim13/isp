<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $company =  Company::create([
            'logo' => 'logo.png',
            'favicon' => 'logo.png',
            'invoice_logo' => 'logo.png',
            'company_name' => 'ISP',
            'website' => 'ISP',
            'phone' => '+8801781818181',
            'email' => 'email@example.com',
            'address' => 'House-12, Road-4, Uttara',
            'created_by' => '1',
            'updated_by' => '1',
        ]);

        $user = new User();
        $user->name = "ISP";
        $user->email = "info@itwaybd.com";
        $user->username = "isp123";
        $user->company_id = $company->id;
        $user->is_admin = 1;
        $user->roll_id = 1;
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
