<?php

namespace App\Model\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasRoles, HasApiTokens, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function hasPermissionTo($permission, $guardName = 'web'): bool
  {
    $permissionClass = $this->getPermissionClass();

    if (is_string($permission)) {
      $permission = $permissionClass->findByName(
        $permission,
        $guardName ?? $this->getDefaultGuardName()
      );
    }

    if (is_int($permission)) {
      $permission = $permissionClass->findById(
        $permission,
        $guardName ?? $this->getDefaultGuardName()
      );
    }

    if (! $permission instanceof Permission) {
      throw new PermissionDoesNotExist;
    }

    return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
  }

  protected function getDefaultGuardName(): string
  {
    return 'web';
  }

  public function posts(): HasMany {
    return $this->hasMany(\App\Model\Blog\Post::class);
  }

  public function datasets(): HasMany {
    return $this->hasMany(\App\Model\Data\Dataset::class);
  }

  public function resources(): HasMany {
    return $this->hasMany(\App\Model\Data\Dataresource::class);
  } 

  public function downloads(): HasMany {
    return $this->hasMany(\App\Model\Data\Datadownload::class);
  }

  public function trackerItems(): HasMany {
    return $this->hasMany(\App\Model\Tracker\TrackerItem::class);
  }

  public function products(): HasMany {
    return $this->hasMany(\App\Model\Products\Product::class);
  }
}
