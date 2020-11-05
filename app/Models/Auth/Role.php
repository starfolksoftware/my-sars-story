<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
  use HasFactory;
  
  protected $guard_name = 'web';
}
