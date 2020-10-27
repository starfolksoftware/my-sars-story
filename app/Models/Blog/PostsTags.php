<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostsTags extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_tags';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsTo(\App\Models\Blog\Post::class);
    }

    public function tags()
    {
        return $this->belongsTo(\App\Models\Blog\Tag::class);
    }
}
