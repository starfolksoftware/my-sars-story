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

Auth::routes(['register'=>false]);

// blog post show route
Route::get('/blog/{identifier}/{slug}', 'Controller')->name('blog-show');

// Catch-all routes...
Route::get('/{view?}', 'Controller')->where('view', '(.*)')->name('tenant');
