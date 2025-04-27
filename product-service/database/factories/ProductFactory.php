<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->words(3, true), // Random product name
            'description' => $this->faker->sentence, // Random description
            'price' => $this->faker->randomFloat(2, 5, 500), // Random price
            'stock_quantity' => $this->faker->numberBetween(1, 100), // Random stock quantity
            'status' => $this->faker->boolean(80) ? 1 : 0, // Random status with 80% chance to be 1
            'main_image_url' => $this->faker->imageUrl(640, 480, 'products', true), // Random image URL
            'collection_image_url' => json_encode([ // Create a random JSON array for collection_image_url
                $this->faker->imageUrl(640, 480, 'products', true), 
                $this->faker->imageUrl(640, 480, 'products', true)
            ]), // Generates random JSON structure with 2 images
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? null, // Random category ID or null if no categories exist
        ];
    }
}
