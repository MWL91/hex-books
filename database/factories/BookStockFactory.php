<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = rand(5, 10);

        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'isbn' => $this->faker->randomNumber(),
            'quantity' => $quantity,
            'in_stock' => $quantity - rand(1, 5),
        ];
    }
}
