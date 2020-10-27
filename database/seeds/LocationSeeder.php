<?php

use Illuminate\Database\Seeder;

use App\Models\Location\{State,LocalGovernment};

class LocationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = base_path('public/assets/location/states.csv');
    $statesArr = Helper::csvToArray($file);
    
    for ($i = 0; $i < count($statesArr); $i ++) {
      State::firstOrCreate($statesArr[$i]);
    }

    $file = base_path('public/assets/location/local_governments.csv');
    $lgArr = Helper::csvToArray($file);

    for ($i = 0; $i < count($lgArr); $i ++) {
      LocalGovernment::firstOrCreate($lgArr[$i]);
    }
  }
}
