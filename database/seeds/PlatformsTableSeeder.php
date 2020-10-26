<?php

use Illuminate\Database\Seeder;
use App\Model\Settings\Platform;

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
      $platform->name = 'Starfolk Software';
      $platform->save();
    }
}
