<?php

namespace Database\Factories;

use App\Models\Slideshow;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlideshowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slideshow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(1920, 1080, 'business', true),
            'caption' => $this->faker->optional()->sentence,
            'description' => $this->faker->optional()->paragraph,
            'link' => $this->faker->optional()->url,
            'status' => $this->faker->boolean(80) ? 1 : 0,
            'category_id' => Category::inRandomOrder()->first()->id ?? null, // Ensure this references Category correctly
        ];
    }
}
