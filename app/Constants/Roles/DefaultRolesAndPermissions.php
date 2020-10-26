<?php

namespace App\Constants\Roles;

class DefaultRolesAndPermissions
{
  public static function permissions() {
    return [
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
       * datasets permissions
       */
      'create_datasets',
      'update_datasets',
      'update_own_datasets',
      'view_datasets',
      'view_own_datasets',
      'delete_datasets',
      'delete_own_datasets',
      'approve_datasets',
      'publish_datasets',

      /**
       * dataformats permissions
       */
      'create_dataformats',
      'update_dataformats',
      'view_dataformats',
      'delete_dataformats',

      /**
       * datalicenses permissions
       */
      'create_datalicenses',
      'update_datalicenses',
      'view_datalicenses',
      'delete_datalicenses',

      /**
       * datatopics permissions
       */
      'create_datatopics',
      'update_datatopics',
      'view_datatopics',
      'delete_datatopics',

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
       * designations permissions
       */
      'create_designations',
      'update_designations',
      'view_designations',
      'delete_designations',

      /**
       * members permissions
       */
      'create_members',
      'update_members',
      'view_members',
      'delete_members',

      /**
       * services permissions
       */
      'create_services',
      'update_services',
      'view_services',
      'delete_services',

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
       * datasets permissions
       */
      'create_datasets',
      'update_datasets',
      'update_own_datasets',
      'view_datasets',
      'view_own_datasets',
      'delete_datasets',
      'delete_own_datasets',
      'approve_datasets',
      'publish_datasets',

      /**
       * dataformats permissions
       */
      'create_dataformats',
      'update_dataformats',
      'view_dataformats',

      /**
       * datalicenses permissions
       */
      'create_datalicenses',
      'update_datalicenses',
      'view_datalicenses',
      'delete_datalicenses',

      /**
       * datatopics permissions
       */
      'create_datatopics',
      'update_datatopics',
      'view_datatopics',
      'delete_datatopics',

      /**
       * datatags permissions
       */
      'create_datatags',
      'update_datatags',
      'view_datatags',
      'delete_datatags',

      /**
       * products permissions
       */
      'create_products',
      'update_products',
      'view_products',
      'delete_products',

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
      'Editor',
      'Data Curator',
      'Data Researcher & Editor'
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

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'view_datatopics',
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

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',
        'delete_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',
        'delete_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
        'delete_datatopics',
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

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'view_datatopics',
      ],
      'Data Curator' => [
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

        /**
         * datasets permissions
         */
        'create_datasets',
        'update_datasets',
        'update_own_datasets',
        'view_datasets',
        'view_own_datasets',
        'delete_datasets',
        'delete_own_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
      ],
      'Data Researcher & Editor' => [
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

        /**
         * datasets permissions
         */
        'create_datasets',
        'update_datasets',
        'update_own_datasets',
        'view_datasets',
        'view_own_datasets',
        'delete_datasets',
        'delete_own_datasets',
        'approve_datasets',
        'publish_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',
        'delete_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
        'delete_datatopics',
      ]
    ];
  }
}
