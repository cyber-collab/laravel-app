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
        $chunkSize = 1000;

        $totalEmployees = Employee::count();
        $totalChunks = ceil($totalEmployees / $chunkSize);

        $randomManagerIds = Employee::inRandomOrder()->pluck('id')->toArray();

        for ($i = 0; $i < $totalChunks; $i++) {
            $employeeIds = Employee::skip($i * $chunkSize)->take($chunkSize)->pluck('id')->toArray();
            $randomManagerId = $randomManagerIds[array_rand($randomManagerIds)];
            $employeeIdsString = implode(',', $employeeIds);

            $sql = "UPDATE employees SET manager_id = $randomManagerId WHERE id IN ($employeeIdsString)";
            \DB::statement($sql);
        }
    }

}
