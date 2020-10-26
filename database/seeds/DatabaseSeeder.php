<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(PermissionsTableSeeder::class);
      $this->call(DatalicenseSeeder::class);
      $this->call(DatavisualisationSeeder::class);
      $this->call(DataformatSeeder::class);
      $this->call(LocationSeeder::class);
      $this->call(PlatformsTableSeeder::class);
    }
}
