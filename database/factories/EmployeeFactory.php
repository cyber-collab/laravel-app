<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $positionIds = Position::pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'position_id' => $this->faker->randomElement($positionIds),
            'hire_date' => $this->faker->date,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
//            'photo' => $this->faker->image('public/images',300,300, null, false)
        ];
    }

    protected function getRandomManagerId()
    {
        $randomEmployee = Employee::inRandomOrder()->first();

        return $randomEmployee ? $randomEmployee->id : null;
    }
}
