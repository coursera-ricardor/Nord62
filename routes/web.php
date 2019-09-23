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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
    Spatie Permissions and Roles
    https://github.com/spatie/laravel-permission
*/
Route::resource('permissions','Access\permissionController');

// Additional Test Methods
Route::get('/roles/{role}/edit2','Access\roleController@edit2')->name('roles.edit2');
Route::get('/roles/{role}/update2Permission','Access\roleController@update2Permission')->name('roles.update2Permission');
// Standard Methods
Route::resource('roles','Access\roleController');

/*
    Users and Profiles
*/
Route::match(['put','patch'],'/users/{user}/updateProfile','Access\userController@updateProfile')->name('users.updateProfile');
Route::match(['put','patch'],'/users/{user}/updateRoles','Access\userController@updateRoles')->name('users.updateRoles');
Route::match(['put','patch'],'/users/{user}/updatePermissions','Access\userController@updatePermissions')->name('users.updatePermissions');
Route::resource('users','Access\userController');
