<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelOrder>
 */
class TravelOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureDate = fake()->dateTimeBetween('+1 week', '+1 month');
        $returnDate = fake()->dateTimeBetween($departureDate, $departureDate->format('Y-m-d H:i:s') . ' +2 week');

        return [
            'user_id' => User::factory(),
            'requester_name' => fake()->name(),
            'destination' => fake()->city(),
            'departure_date' => $departureDate,
            'return_date' => $returnDate,
            'status' => fake()->randomElement(OrderStatus::cases()),
        ];
    }
}
