<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Resources\Resource;
use Faker\Generator as Faker;

$factory->define(Resource::class, function (Faker $faker) {
    return [
        "id" => $faker->uuid,
        "title" => $faker->realText(150),
        "description" => $faker->text(1000),
        "path" => "/images/portfolio/bg/bg5.jpg",
        "user_id" => 1
    ];
});
