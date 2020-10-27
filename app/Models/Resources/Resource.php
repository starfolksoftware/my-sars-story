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
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


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
