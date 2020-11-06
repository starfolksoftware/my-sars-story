<?php

namespace App\Models\Memorial;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memorial extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [];

  public function post(): BelongsTo {
    return $this->belongsTo(Post::class);
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
      $item->post()->delete();
    });
  }
}
