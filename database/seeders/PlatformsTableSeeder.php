<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\Platform;

class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $platform = new Platform();
      $platform->name = 'MySarsStory';
      $platform->save();
    }
}
