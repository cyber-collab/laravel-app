<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $randomManager = Employee::inRandomOrder()->first();

            $employee->update([
                'manager_id' => $randomManager->id,
            ]);
        }
    }
}
