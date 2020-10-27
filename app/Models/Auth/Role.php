<?php

namespace App\Models\Auth;

class Role extends \Spatie\Permission\Models\Role
{
  protected $guard_name = 'web';

  protected $casts = [
    'permissions' => 'array',
  ];
}
