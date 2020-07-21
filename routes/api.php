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

// Auth User
Route::post('login', 'API\AuthController@login'); 
Route::post('logout','API\AuthController@logout');


// Users Actions
Route::post('users', 'API\UsersController@index');
Route::post('add_users', 'API\UsersController@store'); 
Route::post('edit_users', 'API\UsersController@update'); 
Route::post('delete_user', 'API\UsersController@destroy');

