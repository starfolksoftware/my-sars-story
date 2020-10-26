<?php

namespace App\Constants\Roles;

class DefaultRolesAndPermissions
{
  public static function permissions() {
    return [
      /**
       * stats
       */
      'view_stats',
      
      /**
       * posts permissions
       */
      'create_posts',
      'update_posts',
      'update_own_posts',
      'view_posts',
      'view_own_posts',
      'delete_posts',
      'delete_own_posts',
      'approve_posts',
      'publish_posts',

      /**
       * platforms
       */
      'create_platforms',
      'update_platforms',
      'view_platforms',
      'delete_platforms',

      /**
       * roles permissions
       */
      'create_roles',
      'update_roles',
      'view_roles',
      'delete_roles',

      /**
       * users permissions
       */
      'view_users',
      'view_own_users',
      'create_users',
      'update_users',
      'update_own_users',
      'delete_users',
      'delete_own_users',
      'change_users_password',
      'change_users_own_password',

      /**
       * partners permissions
       */
      'create_partners',
      'update_partners',
      'view_partners',
      'delete_partners',

      /**
       * members permissions
       */
      'create_memorial',
      'update_memorial',
      'view_memorial',
      'delete_memorial',

      /**
       * trackers permissions
       */
      'create_trackers',
      'update_trackers',
      'view_trackers',
      'delete_trackers',

      /**
       * trackers permissions
       */
      'create_tracker_items',
      'update_tracker_items',
      'view_tracker_items',
      'delete_tracker_items',

      /**
       * comments permissions
       */
      'create_comments',
      'update_comments',
      'view_comments',
      'delete_comments',
      'approve_comments',

      /**
       * Location permissions
       */
      'view_states', 
      'create_states', 
      'update_users', 
      'delete_states', 
      'view_local_governments', 
      'create_local_governments', 
      'update_local_governments', 
      'delete_local_goverments',
    ];
  }

  public static function roles() {
    return [
      'Admin',
      'User',
      'Writer',
      'Editor'
    ];
  }

  public static function rolesWithPermissions() {
    return [
      'Admin' => self::permissions(),
      'User' => [
        /**
         * posts permissions
         */
        'view_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',
      ],
      'Writer' => [
        /**
         * posts permissions
         */
        'create_posts',
        'update_own_posts',
        'view_posts',
        'view_own_posts',
        'delete_own_posts',
        'publish_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',
      ],
      'Editor' => [
        /**
         * posts permissions
         */
        'create_posts',
        'update_posts',
        'update_own_posts',
        'view_posts',
        'view_own_posts',
        'delete_posts',
        'delete_own_posts',
        'approve_posts',
        'publish_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',
      ],
    ];
  }
}
