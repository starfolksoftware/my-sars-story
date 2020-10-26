<?php

namespace App\Model\Tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasComments;
use App\Model\Location\{State, LocalGovernment};

class TrackerItem extends Model
{
  use HasComments;

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
    'confirmed' => 'boolean',
    'meta' => 'array',
  ];

  /**
   * Scope a query to only include confirmed.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeConfirmed($query): Builder
  {
    return $query->where('confirmed', true);
  }

  /**
   * Scope a query to only include unconfirmed.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeNotConfirmed($query): Builder
  {
    return $query->where('confirmed', false);
  }

  public function tracker(): BelongsTo {
    return $this->belongsTo(Tracker::class);
  }

  public function user(): BelongsTo {
    return $this->belongsTo(\App\Model\Auth\User::class);
  }

  public function state(): BelongsTo {
    return $this->belongsTo(State::class);
  }

  public function localGovernment(): BelongsTo {
    return $this->belongsTo(LocalGovernment::class);
  }
}
