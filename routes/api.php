<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['prefix' => 'v1'], function () {
  // Stats routes...
  Route::namespace('Analytics')->group(function () {
    Route::get('/stats', 'StatsController@index')->middleware(['auth:api', 'permission:view_stats']);
    Route::get('/stats/{id}', 'StatsController@show')->middleware(['auth:api', 'permission:view_stats']);  
  });

  // Blog routes...
  Route::namespace('Blog')->group(function () {
    Route::get('/posts', 'PostController@index')
      ->middleware(['auth:api', 'permission:view_posts']);
    Route::get('/posts/{id?}', 'PostController@show')
      ->middleware(['auth:api', 'permission:view_posts|view_own_posts']);
    Route::post('/posts/{id}', 'PostController@store')
      ->middleware(['auth:api', 'permission:create_posts|update_posts|update_own_posts|approve_posts|publish_posts']);
    Route::delete('/posts/{id}', 'PostController@destroy')
      ->middleware(['auth:api', 'permission:delete_posts|delete_own_posts']);

    // Tag routes...
    Route::get('/tags', 'TagController@index')->middleware(['auth:api', 'permission:view_tags']);
    Route::get('/tags/{id?}', 'TagController@show')->middleware(['auth:api', 'permission:view_tags']);
    Route::post('/tags/{id}', 'TagController@store')->middleware(['auth:api', 'permission:create_tags|update_tags']);
    Route::delete('/tags/{id}', 'TagController@destroy')->middleware(['auth:api', 'permission:delete_tags']);

    // Topic routes...
    Route::get('/topics', 'TopicController@index')->middleware(['auth:api', 'permission:view_topics']);
    Route::get('/topics/{id?}', 'TopicController@show')->middleware(['auth:api', 'permission:view_topics']);
    Route::post('/topics/{id}', 'TopicController@store')->middleware(['auth:api', 'permission:create_topics|update_topics']);
    Route::delete('/topics/{id}', 'TopicController@destroy')->middleware(['auth:api', 'permission:delete_topics']);

    Route::prefix('blog')->group(function () {
      Route::prefix('posts')->group(function () {
        Route::get('/{limit?}', 'BlogPostController@index');
        Route::get('{identifier}/{slug}', 'BlogPostController@show'); //->middleware('Canvas\Http\Middleware\Session')
      });
  
      Route::prefix('tags')->group(function () {
        Route::get('/', 'BlogTagController@index');
        Route::get('{slug}', 'BlogTagController@show');
      });
  
      Route::prefix('topics')->group(function () {
        Route::get('/', 'BlogTopicController@index');
        Route::get('{slug}', 'BlogTopicController@show');
      });
  
      Route::prefix('users')->group(function () {
        Route::get('{identifier}', 'BlogUserController@show');
      });
    });
  });

  // Auth routes...
  Route::namespace('Auth')->group(function () {
    Route::get('/users', 'UserController@index')
      ->middleware(['auth:api', 'permission:view_users']);
    Route::get('/users/{id?}', 'UserController@show')
      ->middleware(['auth:api', 'permission:view_users|view_own_users']);
    Route::post('/users/{id}', 'UserController@store')
      ->middleware(['auth:api', 'permission:create_users|update_users|update_own_users']);
    Route::delete('/users/{id}', 'UserController@destroy')
      ->middleware(['auth:api', 'permission:delete_users']);

    // Role routes...
    Route::get('/roles', 'RoleController@index')
      ->middleware(['auth:api', 'permission:view_roles']);
    Route::get('/roles/{id?}', 'RoleController@show')
      ->middleware(['auth:api', 'permission:view_roles']);
    Route::post('/roles/{id}', 'RoleController@store')
      ->middleware(['auth:api', 'permission:create_roles|update_roles']);
    Route::delete('/roles/{id}', 'RoleController@destroy')
      ->middleware(['auth:api', 'permission:delete_roles']);

    // Permission routes...
    Route::get('/permissions', function () {
      return response()->json(\App\Models\Auth\Permission::all()->pluck('name'));
    })->middleware(['auth:api', 'role:Admin']);
  });

  // Settings routes...
  Route::namespace('Settings')->group(function () {
    // Platform routes...
    Route::get('/platforms', 'PlatformController@index')
      ->middleware(['auth:api', 'role:Admin']);
    Route::get('/platforms/{id?}', 'PlatformController@show')
      ->middleware(['auth:api', 'role:Admin']);
    Route::post('/platforms/{id}', 'PlatformController@store')
      ->middleware(['auth:api', 'role:Admin']);
    Route::delete('/platforms/{id}', 'PlatformController@destroy')
      ->middleware(['auth:api', 'role:Admin']);
    // Settings routes...
    Route::get('/settings', 'SettingsController@show')
      ->middleware(['auth:api']);
    Route::post('/settings', 'SettingsController@update')
      ->middleware(['auth:api']);
    Route::prefix('locale')->group(function () {
      Route::post('/', 'LocaleController@update');
    });
  });

  Route::namespace('Util')->group(function () {
    // Media routes...
    Route::post('/media/uploads', 'MediaController@store')
      ->middleware(['auth:api']);
    Route::delete('/media/uploads', 'MediaController@destroy')
      ->middleware(['auth:api']);

    // comments routes...
    Route::get('/comments', 'CommentController@index');
    Route::delete('/comments/{commentableType}/{id}', 'CommentController@destroy')
      ->middleware(['auth:api', 'permission:delete_comments']);

    // contact...
    Route::post('/contact', 'ContactController');
  });

  Route::namespace('Partners')->group(function () {
    // Partners routes...
    Route::get('/partners', 'PartnerController@index');
    Route::get('/partners/{id?}', 'PartnerController@show');
    Route::post('/partners/{id}', 'PartnerController@store')
      ->middleware(['auth:api', 'permission:create_partners']);
    Route::delete('/partners/{id}', 'PartnerController@destroy')
      ->middleware(['auth:api', 'permission:delete_partners']);
  });

  Route::namespace('Memorial')->group(function () {
    // memorials routes...
    Route::get('/memorial', 'MemorialController@index');
    Route::get('/memorial/{id?}', 'MemorialController@show');
    Route::post('/memorial/{id}', 'MemorialController@store')
      ->middleware(['auth:api', 'permission:create_memorial|update_memorial'])->name('memorial.store');
    Route::delete('/memmemorialbers/{id}', 'MemorialController@destroy')
      ->middleware(['auth:api', 'permission:delete_memorial'])->name('memorial.destroy');
  });

  Route::namespace('Tracker')->group(function () {
    // trackers routes...
    Route::get('/trackers', 'TrackerController@index');
    Route::get('/trackers/{id?}', 'TrackerController@show');
    Route::post('/trackers/{id}', 'TrackerController@store')
      ->middleware(['auth:api', 'permission:create_trackers']);
    Route::delete('/trackers/{id}', 'TrackerController@destroy')
      ->middleware(['auth:api', 'permission:delete_trackers']);

    // trackerItems routes...
    Route::get('/trackerItems/{trackerId}', 'TrackerItemController@index');
    Route::get('/trackerItems/{trackerId}/{id?}', 'TrackerItemController@show');
    Route::post('/trackerItems/{trackerId}/{id}', 'TrackerItemController@store');
    Route::delete('/trackerItems/{trackerId}/{id}', 'TrackerItemController@destroy')
      ->middleware(['auth:api', 'permission:delete_tracker_items']);
  });

  Route::namespace('Location')->group(function () {
    Route::get('/states', 'StateController@index');
    Route::get('/localGovernments', 'LocalGovernmentController@index');
  });

  Route::namespace('Resources')->group(function () {
    // resources routes...
    Route::get('/resources', 'ResourceController@index');
    Route::get('/resources/{id?}', 'ResourceController@show');
    Route::post('/resources/{id}', 'ResourceController@store')->middleware(['auth:api', 'permission:create_resources|update_resources']);
    Route::delete('/resources/{id}', 'ResourceController@destroy')->middleware(['auth:api', 'permission:delete_resources']);
  });

  Route::namespace('')->group(function () {

  });
});
