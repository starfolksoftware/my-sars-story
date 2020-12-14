<?php

namespace Database\Factories\Memorial;

use App\Models\Memorial\Memorial;
use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemorialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Memorial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => NULL,
            "name" => $this->faker->name(),
            "profession" => $this->faker->company,
            "age" => $this->faker->randomNumber(),
            "post_id" => Post::factory(),
            "avatar" => "/images/male_avatar.svg",
        ];
    }
}
