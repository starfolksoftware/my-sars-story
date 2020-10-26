<?php

use Illuminate\Database\Seeder;

use App\Model\Data\Datavisualisation;
use App\Model\Data\Dataformat;

class DataformatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $allFormats = Dataformat::defaultFormats();

      foreach ($allFormats as $format) {
        Dataformat::firstOrCreate($format);
      }

      $format = Dataformat::where('extension', 'csv')->first();
      $format->previews()->attach(Datavisualisation::where('name', 'Table')->first());
      $format->previews()->attach(Datavisualisation::where('name', 'Chart')->first());

      $format = Dataformat::where('extension', 'jpg')->first();
      $format->previews()->attach(Datavisualisation::where('name', 'Image')->first());

      $format = Dataformat::where('extension', 'jpeg')->first();
      $format->previews()->attach(Datavisualisation::where('name', 'Image')->first());

      $format = Dataformat::where('extension', 'png')->first();
      $format->previews()->attach(Datavisualisation::where('name', 'Image')->first());

      $format = Dataformat::where('extension', 'gif')->first();
      $format->previews()->attach(Datavisualisation::where('name', 'Image')->first());
    }
}
