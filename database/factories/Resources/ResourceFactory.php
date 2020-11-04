<?php

namespace Database\Factories\Resources;

use App\Models\Resources\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => $this->faker->uuid,
            "title" => $this->faker->realText(150),
            "description" => $this->faker->text(1000),
            "path" => "/images/portfolio/bg/bg5.jpg",
            "user_id" => 1
        ];
    }
}
