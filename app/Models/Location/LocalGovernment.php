<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsTo};
use App\Models\Auth\User;
use App\Models\Tracker\TrackerItem;

class LocalGovernment extends Model
{
  use SoftDeletes;
  
  public function state (): BelongsTo {
    return $this->belongsTo(State::class);
  }

  public function trackerItems (): HasMany {
    return $this->hasMany(TrackerItem::class);
  }
}
