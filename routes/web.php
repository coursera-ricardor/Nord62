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
/*
    Authentication middleware via routes
*/
Route::get('/roles/{role}/edit2','Access\roleController@edit2')->name('roles.edit2')->middleware('auth');
/*
    NOTE: the difference between the previous route, without the middleware if the "Controller" does not have
    in the constructor __construct the middleware, the action in the "resource", line below, does not have any effect
    in this route.
*/
Route::get('/roles/{role}/update2Permission','Access\roleController@update2Permission')->name('roles.update2Permission');
// Standard Methods
Route::resource('roles','Access\roleController')->middleware('auth');

/*
    Users and Profiles
    NOTE: Authentication is implemented in the constructor of the controller.
        This approach could lead a failure in the security if for some reason it is removed or commented in the controller.
        In this example only the first route will be protected, via "route" and "Controller"
*/
Route::match(['put','patch'],'/users/{user}/updateProfile','Access\userController@updateProfile')->name('users.updateProfile')->middleware('auth');
Route::match(['put','patch'],'/users/{user}/updateRoles','Access\userController@updateRoles')->name('users.updateRoles');
Route::match(['put','patch'],'/users/{user}/updatePermissions','Access\userController@updatePermissions')->name('users.updatePermissions');
Route::resource('users','Access\userController');

/*
    Profiles - Projects
*/
Route::resource('profiles_projects','Op\profileProjectController');

/*
    Searchs
*/
Route::get('search/servicecity', 'Search\SearchCatalogController@index')->name('search.form');
Route::match(['get','post'],'search/{model}/lookup/{field}/{response?}', 'Search\SearchCatalogController@Lookup')->name('search.lookup');
// Route::match(['get','post'],'search/{model}/lookup', 'Search\SearchCatalogController@Lookup')->name('search.lookup');
Route::post('search/{model}/{keyid}/lookup', 'Search\SearchCatalogController@searchLookupSet')->name('search.lookupSet');

Route::get('autocomplete', 'Search\SearchCatalogController@autocomplete')->name('autocomplete');

Route::get('search/lookup2', 'Search\SearchCatalogController@Lookup2')->name('search.lookup2');

// DataTables Ajax Call - Server Side
Route::get('search/lookup_ss', 'Search\SearchCatalogController@Lookup_ss')->name('search.lookup_ss');
// DataTables Ajax Call - Client Side
Route::get('search/lookup_cs', 'Search\SearchCatalogController@Lookup_cs')->name('search.lookup_cs');



Route::post('search/servicecity', 'Search\SearchCatalogController@process')->name('search.processServiceCity');
Route::get('search/servicecitysearch', 'Search\SearchCatalogController@search')->name('search.serviceCityFormSearch');
