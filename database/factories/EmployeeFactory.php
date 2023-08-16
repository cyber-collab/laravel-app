<?php

namespace Database\Factories;

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
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'surname' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'hire_date' => $this->faker->date,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'photo' => $this->faker->image,
        ];
    }
}
