<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
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
    public function definition()
    {
        $description = $this->faker->realText(2000);
        $title = $this->faker->words(3,true);
        return [
            'title'     => $title,
            'slug'      => Str::slug($title),
            'description' => $description,
            'excerpt'   =>  Str::words($description,50,' ...'),
            'user_id'   => rand(1,14),
            'category_id'   => rand(1,5),
        ];
    }
}
