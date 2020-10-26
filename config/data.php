<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Route
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Data will be accessible from. You are free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => env('DATA_PATH_NAME', '/'),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be attached to every route in Data, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with the list.
    |
    */

    'middleware' => [
      'web',
      'auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Data will use to put file uploads. You may
    | use any of the disks defined in the config/filesystems.php file and
    | you may also change the maximum upload size from its 3MB default.
    |
    */

    'storage_disk' => env('DATA_STORAGE_DISK', 'local'),

    'storage_path' => env('DATA_STORAGE_PATH', 'public/data'),

    'upload_filesize' => env('DATA_UPLOAD_FILESIZE', 3145728),

    /*
    |--------------------------------------------------------------------------
    | E-Mail Notifications
    |--------------------------------------------------------------------------
    |
    | This option controls e-mail notifications that will be sent via the
    | default application mail driver. A default option is provided to
    | support the notification system as an opt-in feature.
    |
    |
    */

    'mail' => [
      'enabled' => env('DATA_MAIL_ENABLED', false),
    ],

];
