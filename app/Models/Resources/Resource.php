<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [];

    /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::deleting(function ($item) {
      //
    });
  }
}
