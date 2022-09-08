<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'account_number' => fake()->unique()->randomNumber(8,true),
            'contract_number' => fake()->unique()->randomNumber(4,true),
            'contact' => fake()->e164PhoneNumber(),
            'email' => fake()->companyEmail(),
            'company' => fake()->company(),
        ];
    }
}
