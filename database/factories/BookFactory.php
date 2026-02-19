<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            $total = $this->faker->numberBetween(1, 10);
            $available = $this->faker->numberBetween(0, $total);

            return [
                'title' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(),
                'ISBN' => $this->faker->unique()->isbn13(),
                'total_copies' => $total,
                'available_copies' => $available,
                'is_available' => $available > 0,
            ];
    }
}
