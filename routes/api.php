<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List all countries
// Route::get('countries', 'Catalogs/CountryController@index')->name('search.api.countries');

// Route::apiResources([
    //'countries' => 'API\Catalogs\CountryController',
// ]);

Route::namespace('API')
    ->name('api.search.')
    ->group( function() {
        Route::Resource('countries','Catalogs\CountryController');
    });
