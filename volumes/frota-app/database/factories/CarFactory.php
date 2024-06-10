<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->randomElement(['Ford', 'Chevrolet', 'Toyota', 'Honda']),
            'model' => $this->faker->randomElement(['Focus', 'Civic', 'Corolla', 'Cruze']),
            'year' => $this->faker->year,
            'color' => $this->faker->colorName,
            'license_plate' => $this->faker->lexify('???-####'),
        ];
    }
}
