<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'slug'=> $this->faker->unique()->slug,
            'summary'=>$this->faker->setences(nb:3, asText:true),
            'photo' =>$this->faker->imageUrl(width:'188',heigh:'188'),
            'is_parent' =>$this->faker->randomElement([true,false]),
            'status' =>$this->faker->randomElement(['active','inactive']),
            'parent_id' =>$this->faker->randomElement(Category::pluck('id')->toArray()),
        ];
    }
}
