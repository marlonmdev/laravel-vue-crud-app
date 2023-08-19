<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->text(20);
        return [
            'name'  => $name, 
            'slug' => Str::slug($name),
            'price' => rand(1000, 20000),
            'image' => null,
            'description' => fake()->realText(200)
        ];
    }
}
