<?php

use Illuminate\Database\Seeder;

use App\Model\Data\Datavisualisation;

class DatavisualisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $allPreviews = Datavisualisation::defaultPreviews();

      foreach ($allPreviews as $preview) {
        Datavisualisation::firstOrCreate($preview);
      }
    }
}
