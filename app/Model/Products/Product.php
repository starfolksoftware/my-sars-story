<?php

namespace App\Model\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasApprovalFlow;

class Product extends Model
{
  use SoftDeletes, HasApprovalFlow;
  
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'products';

  protected $guarded = [];

  /**
   * The number of models to return for pagination.
   *
   * @var int
   */
  protected $perPage = 10;

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
    'submitted_at',
    'approved_at',
    'published_at',
  ];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'marketing' => 'array',
    'features' => 'array'
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(\App\Model\Auth\User::class);
  }

  /**
   * Scope a query to only include posts for the current logged in user.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeForCurrentUser($query): Builder
  {
    return $query->where('user_id', request()->user()->id ?? null);
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
      //
    });
  }
}
