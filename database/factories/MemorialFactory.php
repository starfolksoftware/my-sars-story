<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Memorial\Memorial;
use Faker\Generator as Faker;

$factory->define(Memorial::class, function (Faker $faker) {
    return [
        "name" => $faker->name() ,
        "profession" => $faker->company,
        "age" => $faker->randomNumber(),
        "post_id" => $faker->uuid,
        "avatar" => "/images/male_avatar.svg",
    ];
});
