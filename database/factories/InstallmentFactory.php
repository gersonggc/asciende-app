<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Installment>
 */
class InstallmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        \App\Models\Contract::all()->each(function ($contract) {
            $contract->installments()->saveMany(\App\Models\Installment::factory(3)->make());
        });
        
        // return [
        //     'contract_id' => \App\Models\Contract::factory(),
        //     'amount' => $this->faker->randomFloat(2, 100, 1000),
        //     'due_date' => $this->faker->date(),
        //     'status' => $this->faker->randomElement(['PENDING', 'PAID', 'LATE']),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ];
    }
}
