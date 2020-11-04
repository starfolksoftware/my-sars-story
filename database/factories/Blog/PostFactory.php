<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => $this->faker->uuid, // uuid
            "slug" => $this->faker->slug,
            "title" => $this->faker->sentence(12, true),
            "summary" => $this->faker->paragraph(5, true),
            "body" => $this->faker->text(1200) ,
            "submitted_at" => $this->faker->dateTime('now'),
            "approved_at" => $this->faker->dateTime('now'),
            "editor_id" => 1,
            "published_at" => $this->faker->dateTime('now'),
            "featured_image" => "/images/portfolio/bg/bg5.jpg",
            "featured_image_caption" => $this->faker->sentence(6, true),
            "user_id" => 1,
            "meta" => [
                "description" => $this->faker->paragraph(5, true),
                "title" => $this->faker->sentence(12, true),
                "canonical_link" => "",
            ]
        ];
    }
}
