<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
  protected $guard_name = 'web';
}
