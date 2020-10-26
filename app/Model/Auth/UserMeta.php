<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class UserMeta extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'user_meta';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'digest' => 'boolean',
    'dark_mode' => 'boolean',
  ];

  /**
   * Get the user relationship.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
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
}
