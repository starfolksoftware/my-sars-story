<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Datalicense extends Model
{
  use SoftDeletes;

  protected $guarded = [];

  public static function defaultLicenses() {
    return [
      [
        'name' => 'Creative Commons Attribution',
        'link' => 'https://creativecommons.org/licenses/',
      ],
      [
        'name' => 'Creative Commons Attribution Share-Alike',
        'link' => 'https://creativecommons.org/licenses/',
      ],
      [
        'name' => 'Creative Commons CC Zero',
        'link' => 'https://creativecommons.org/licenses/',
      ],
      [
        'name' => 'Creative Commons Non-Commercial(Any)',
        'link' => 'https://creativecommons.org/licenses/',
      ],
      [
        'name' => 'Attribution Non-Commercial No Derivatives 4.0 International',
        'link' => 'https://creativecommons.org/licenses/',
      ],
      [
        'name' => 'GNU Free Documentation Licenses',
        'link' => 'https://www.gnu.org/licenses/fdl-1.3.en.html',
      ],
      [
        'name' => 'Open Data Commons Attribution License',
        'link' => '#',
      ],
      [
        'name' => 'Open Data Commons Open Database License',
        'link' => 'https://opendatacommons.org/licenses/by/1-0/',
      ],
      [
        'name' => 'Open Data Commons Publisc Domain Dedication And License',
        'link' => 'https://opendatacommons.org/licenses/by/1-0/',
      ],
      [
        'name' => 'UK Open Government License(OGL)',
        'link' => 'http://www.nationalarchives.gov.uk/doc/open-government-licence/version/3/',
      ],
      [
        'name' => 'Other(Attribution)',
        'link' => '#',
      ],
      [
        'name' => 'Other(Non-Commercial)',
        'link' => '#',
      ],
      [
        'name' => 'Other(Not Open)',
        'link' => '#',
      ],
      [
        'name' => 'Other(Open)',
        'link' => '#',
      ],
      [
        'name' => 'Other(Public Domain)',
        'link' => '#',
      ],
      [
        'name' => 'Other(License Not Specified)',
        'link' => '#',
      ]
    ];
  }

  public function datasets(): HasMany {
    return $this->hasMany(\App\Model\Data\Dataset::class, 'datalicense_id');
  }
}
