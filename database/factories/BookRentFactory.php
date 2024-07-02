<?php

namespace Database\Factories;

use App\Enums\BookRentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookRent>
 */
class BookRentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'rented_at' => $this->faker->dateTime(),
            'returned_at' => null,
            'status' => BookRentStatus::RENTED
        ];
    }
}
