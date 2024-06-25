<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomNumber(8),
            'client_id' => \App\Models\Client::factory(),
            'guarantor_id' => \App\Models\Client::factory(),
            'initial_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'total_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'initial' => $this->faker->randomFloat(2, 0, 1000),
            'payment_frequency' => $this->faker->randomElement(['fortnightly', 'monthly']),
            'installments_number' => $this->faker->numberBetween(1, 12),
            'percentage' => $this->faker->randomFloat(2, 0, 100),
            'profit' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement(['APPROVED', 'REJECTED', 'ENDING']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'terms' => $this->faker->sentence,
            'notes' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
