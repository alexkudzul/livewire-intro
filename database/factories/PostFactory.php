<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            // true => se creara una ruta similar a este: public/storage/posts/image1.
            // false => almacena solo el nombre de la imagen.
            'image' => 'posts/' . $this->faker->image('public/storage/posts', 640, 480, null, false), // posts/image1
        ];
    }
}
