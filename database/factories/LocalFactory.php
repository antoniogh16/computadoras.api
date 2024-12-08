<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Local>
 */
class LocalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'direccion' => $this->faker->name,
            'exterior' => $this->faker->numberBetween(1,3000),
            'departamento_id' => $this->faker->numberBetween(1,6)
        ];
    }
}
