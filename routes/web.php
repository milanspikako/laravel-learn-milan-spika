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

Route::get('/', 'Frontend\IndexController@index')->name('homepage');

// USERS MODUL START
Route::get('/users', 'Admin\UsersController@index')->name('users.index');
Route::any('/users/login', 'Admin\UsersController@login')->name('users.login');
Route::get('/users/welcome', 'Admin\UsersController@welcome')->name('users.welcome');
Route::get('/users/create', 'Admin\UsersController@create')->name('users.create');
Route::post('/users/store', 'Admin\UsersController@store')->name('users.store');
Route::get('/users/logout', 'Admin\UsersController@logout')->name('users.logout');
Route::get('/users/{user}/edit', 'Admin\UsersController@edit')->name('users.edit');
Route::post('/users/{user}/edit', 'Admin\UsersController@update')->name('users.update');
Route::get('/users/{user}/delete', 'Admin\UsersController@delete')->name('users.delete');
Route::get('/users/{user}/changestatus', 'Admin\UsersController@changestatus')->name('users.changestatus');
Route::any('/users/{user}/changepassword', 'Admin\UsersController@changepassword')->name('users.changepassword');
// USERS MODUL END


// PAGES MODUL START
Route::get('/pages', 'Admin\PagesController@index')->name('pages.index');
Route::get('/pages/create', 'Admin\PagesController@create')->name('pages.create');
Route::post('/pages/store', 'Admin\PagesController@store')->name('pages.store');
// PAGES MODUL END
