<?php

namespace Database\Factories;

use App\Models\Brand;
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
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2,2,100),
            'quantity' => fake()->numberBetween(0,3),
            'google_product_category' => fake()->numberBetween(100,300),
            'fb_product_category' => fake()->numberBetween(100,300),
            'gender' => fake()->randomElement(['female', 'male', 'unisex']),
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'sku' => fake()->randomNumber(6, true),
        ];
    }
}
