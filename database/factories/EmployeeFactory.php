<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $positionIds = Position::pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'position_id' => $this->faker->randomElement($positionIds),
            'hire_date' => $this->faker->date,
            'phone_number' => $this->generateUkrainianPhoneNumber(),
            'email' => $this->faker->safeEmail,
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'manager_level' => $this->faker->numberBetween(1, 5),
            'photo' => $this->faker->image('public/images', 300, 300, null, false),
        ];
    }

    public function generateUkrainianPhoneNumber(): string
    {
        $number = mt_rand(1000000000, 9999999999);

        return '+380'.substr($number, 1);
    }
}
