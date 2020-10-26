<?php

use Illuminate\Database\Seeder;
use App\Model\Data\Datalicense;

class DatalicenseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $allLicenses = Datalicense::defaultLicenses();

    foreach ($allLicenses as $license) {
      Datalicense::firstOrCreate($license);
    }
  }
}
