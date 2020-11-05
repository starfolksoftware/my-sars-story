<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    "verify" => true,
    // "register" => false
]);

// admin route
Route::get('/admin/stats', 'Controller')->name('admin');

// home oroute
Route::get('/', 'Controller')->name('home');

// contact us route
Route::get('/contact', 'Controller')->name('contact');

// resource route
Route::get('/resources', 'Controller')->name('resources');

// memorial route
Route::get('/memorial', 'Controller')->name('memorial');

// blog route
Route::get('/blog', 'Controller')->name('memorial');

// blog post show route
Route::get('/blog/{identifier}/{slug}', 'Controller')->name('blog-show');

// maps route
Route::get('/trackerItems/{id}', 'Controller')->name('maps');

// Catch-all routes...
Route::get('/{view?}', 'Controller')->where('view', '(.*)')->name('tenant');
