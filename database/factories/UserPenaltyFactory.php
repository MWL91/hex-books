<?php

namespace Database\Factories;

use App\Enums\PenaltyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPenalty>
 */
class UserPenaltyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penalty' => $this->faker->randomNumber(2),
            'paid_at' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement([PenaltyStatus::UNPAID, PenaltyStatus::PAID]),
        ];
    }
}
