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

Route::group(
  [ 'middleware' => 'api' ], 
  function ($router) {

    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/refresh', 'AuthController@refresh');
    Route::get('auth/me', 'AuthController@me');


    Route::get('professions', 'ProfessionController@index');
    Route::resource('agencies', 'AgencyController')->except(['create', 'edit']);

    Route::get('contacts', 'ContactController@index');
    Route::get('contacts/{contact}', 'ContactController@show');
    Route::post('contacts', 'ContactController@store');
    Route::post('contacts/{contact}', 'ContactController@update');
    Route::delete('contacts/{contact}', 'ContactController@destroy');

    Route::get('countries', 'CountryController@index');
  }
);

