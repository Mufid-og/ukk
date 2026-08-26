<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kelas' => Kelas::factory(),
            'id_brand' => Brand::factory(),
            'nama' => 'Avanza '.fake()->unique()->word(),
            'warna' => fake()->colorName(),
            'tahun' => (string) fake()->numberBetween(2020, 2025),
            'transmisi' => fake()->randomElement(['Automatic', 'Manual']),
            'kursi' => fake()->numberBetween(4, 7),
            'harga' => fake()->numberBetween(250, 800) * 1000,
            'status' => 'tersedia',
            'img' => null,
        ];
    }

    public function dibooking(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dibooking',
        ]);
    }

    public function disewakan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disewakan',
        ]);
    }
}
