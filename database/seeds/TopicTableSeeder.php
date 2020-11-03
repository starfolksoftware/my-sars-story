<?php

use Illuminate\Database\Seeder;

use App\Models\Blog\Topic;
use Ramsey\Uuid\Uuid;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //video topics
        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Video Testimonies",
            "slug" => "video-testimonies",
            "user_id" => 1,
        ]);

        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Video Docs",
            "slug" => "video-docs",
            "user_id" => 1,
        ]);

        //read topics
        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Narratives",
            "slug" => "narratives",
            "user_id" => 1,
        ]);

        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Investigations",
            "slug" => "investigations",
            "user_id" => 1,
        ]);

        //audio topics
        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Audio Testimonies",
            "slug" => "audio-testimonies",
            "user_id" => 1,
        ]);

        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Audio Stories",
            "slug" => "audio-stories",
            "user_id" => 1,
        ]);

        //resources topics
        Topic::firstOrCreate([
            "id" => Uuid::uuid4(),
            "name" => "Infographics",
            "slug" => "infographics",
            "user_id" => 1,
        ]);
    }
}
