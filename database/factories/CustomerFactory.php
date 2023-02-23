<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_customer' => Str::random(5),
            'nama_customer' => fake()->name(),
            'telp_customer' => fake()->unique()->e164PhoneNumber(),
            'alamat_customer' => fake()->address(),
        ];
    }
}
