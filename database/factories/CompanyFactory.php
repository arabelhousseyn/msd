<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => uniqid(),
            'name' => $this->faker->company(),
            'color' => $this->faker->hexColor(),
            'description' => $this->faker->text(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'logo' => $this->faker->imageUrl(),
            'lang' => $this->faker->languageCode(),
            'is_external' => $this->faker->boolean(),
        ];
    }
}
