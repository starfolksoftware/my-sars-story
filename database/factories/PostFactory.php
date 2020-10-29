<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Blog\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        "id" => $faker->uuid, // uuid
        "slug" => $faker->slug,
        "title" => $faker->sentence(12, true),
        "summary" => $faker->paragraph(5, true),
        "body" => $faker->text(1200) ,
        "submitted_at" => $faker->dateTime('now'),
        "approved_at" => $faker->dateTime('now'),
        "editor_id" => 1,
        "published_at" => $faker->dateTime('now'),
        "featured_image" => "/images/portfolio/bg/bg5.jpg",
        "featured_image_caption" => $faker->sentence(6, true),
        "user_id" => 1,
        "meta" => [
            "description" => $faker->paragraph(5, true),
            "title" => $faker->sentence(12, true),
            "canonical_link" => "",
        ]
    ];
});
