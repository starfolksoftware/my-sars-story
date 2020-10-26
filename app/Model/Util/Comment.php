<?php

namespace App\Model\Util;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasComments;

class Comment extends Model
{
  use HasComments;

  protected $fillable = [
    'comment',
    'user_id',
    'is_approved'
  ];

  protected $casts = [
    'is_approved' => 'boolean'
  ];

  public function scopeApproved($query)
  {
    return $query->where('is_approved', true);
  }

  public function scopeNotApproved($query) {
    return $query->where('is_approved', false);
  }

  public function commentable()
  {
    return $this->morphTo();
  }

  public function commentator()
  {
    return $this->belongsTo($this->getAuthModelName(), 'user_id');
  }

  public function approve()
  {
    $this->update([
      'is_approved' => true,
    ]);

    return $this;
  }

  public function disapprove()
  {
    $this->update([
      'is_approved' => false,
    ]);

    return $this;
  }

  protected function getAuthModelName()
  {
    return "App\Model\Auth\User";

    // throw new Exception('Could not determine the commentator model name.');
  }

}