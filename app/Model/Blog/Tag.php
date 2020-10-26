<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
  use SoftDeletes;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tags';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

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
   * The number of models to return for pagination.
   *
   * @var int
   */
  protected $perPage = 10;

  /**
   * Get the posts relationship.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function posts(): BelongsToMany
  {
    return $this->belongsToMany(\App\Model\Blog\Post::class, 'posts_tags', 'tag_id', 'post_id');
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
      $item->posts()->detach();
    });
  }
}
