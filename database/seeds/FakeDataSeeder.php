<?php

use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = factory(\App\Models\Resources\Resource::class, 100)->create();

        $posts = factory(\App\Models\Blog\Post::class, 100)
            ->create()
            ->each(function ($post) {
                $post->memorial()->save(factory(\App\Models\Memorial\Memorial::class)->create());
            });
    }
}
