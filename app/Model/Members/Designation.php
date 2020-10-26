<?php

namespace App\Model\Members;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Designation extends Model
{
  use SoftDeletes;

  protected $guarded = [];

  public function members(): BelongsToMany {
    return $this->belongsToMany(Member::class);
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
      $item->members()->detach();
    });
  }
}
