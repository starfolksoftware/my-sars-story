<?php

namespace App\Model\Tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tracker extends Model
{
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
    'fields' => 'array',
  ];

  public function trackedItems(): HasMany {
    return $this->hasMany(TrackerItem::class);
  }

  // this is a recommended way to declare event handlers
  public static function boot() {
    parent::boot();
    self::deleting(function($tracker) { // before delete() method call this
      $tracker->trackedItems()->each(function($trackedItem) {
        $trackedItem->delete(); // <-- direct deletion
      });
    });
  } 
}
