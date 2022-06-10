<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Referee>
 */
class RefereeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'gender_id' => 1,
            'age' => rand(30, 45),
            'first_name' => $this->faker->firstNameMale(),
            'last_name' => $this->faker->lastName(),
        ];
    }
}
