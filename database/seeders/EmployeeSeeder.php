<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            ['name' => 'Mostakim', 'month' => '', 'basic_salary' => '10000', 'paid_salary' => '9000'],

        ];
        Employee::insert($employees);
    }
}
