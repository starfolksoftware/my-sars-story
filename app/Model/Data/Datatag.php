<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Datatag extends Model
{
  use SoftDeletes;

  protected $guarded = [];

  public function datasets() {
    return $this->belongsToMany(Dataset::class);
  }
}
