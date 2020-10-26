<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Datavisualisation extends Model
{ 
  use SoftDeletes;

  protected $guarded = [];
  
  public static function defaultPreviews() {
    return [
      [
        'name' => 'Table'
      ],
      [
        'name' => 'Chart'
      ],
      [
        'name' => 'Image'
      ]
    ];
  }

  public function formats(): BelongsToMany {
    return $this->belongsToMany(Dataformat::class);
  }
}
