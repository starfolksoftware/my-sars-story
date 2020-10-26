<?php

namespace App\Model\Members;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
  protected $guarded = [];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'socials_meta' => 'array',
  ];

  public function designations(): BelongsToMany {
    return $this->belongsToMany(Designation::class);
  }

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::deleting(function ($item) {
      $item->designations()->detach();
    });
  }
}
