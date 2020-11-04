<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resources\Resource;
use App\Models\Blog\Post;
use App\Models\Memorial\Memorial;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = Resource::factory()->count(100)->create();

        $posts = Post::factory()->count(50)->create();

        $memorial = Memorial::factory()->count(100)->create();
    }
}
