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
        $totalEmployees = 50000;
        $chunkSize = 500;

        for ($i = 0; $i < $totalEmployees; $i += $chunkSize) {
            Employee::factory($chunkSize)->create();
        }
    }
}
