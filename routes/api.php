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

//Clients actions
Route::post('clients', 'API\ClientController@index');
Route::post('add_clients', 'API\ClientController@store');
Route::post('edit_client', 'API\ClientController@update');
Route::post('delete_client', 'API\ClientController@destroy');

//client Profile
Route::post('client_Cases', 'API\ClientProfileController@client_cases');
Route::post('client_Notes', 'API\ClientProfileController@client_notes');
Route::post('add_clientNote', 'API\ClientProfileController@store');
Route::post('edit_clientNote', 'API\ClientProfileController@Edit_Note');
Route::post('delete_clientNote', 'API\ClientProfileController@delte_Note');

// Mohdareen Actions
Route::post('mohdars', 'API\mohdareenApiController@index');
Route::post('add_mohdars', 'API\mohdareenApiController@store');
Route::post('edit_mohdars', 'API\mohdareenApiController@update');
Route::post('delete_mohdar', 'API\mohdareenApiController@destroy');


//Cases Actions
Route::post('Cases', 'API\casesApiController@index');
Route::post('add_Cases', 'API\casesApiController@store');
Route::post('delete_Case', 'API\casesApiController@destroy');
Route::post('edit_Case', 'API\casesApiController@update');
Route::post('caseData', 'API\casesApiController@caseData');
Route::post('caseClientsData', 'API\casesApiController@caseClientsData');

//Cases Session Actions
Route::post('caseSessions', 'API\sessionApiController@index');
Route::post('addSession', 'API\sessionApiController@store');
Route::post('editSession', 'API\sessionApiController@edit');
Route::post('changeSessionStatus', 'API\sessionApiController@changeSessionStatus');
Route::post('showSession', 'API\sessionApiController@show');
Route::post('deleteSession', 'API\sessionApiController@destroy');

//Cases Session Notes Actions
Route::post('sessionsNote', 'API\sessionNoteApiController@index');
Route::post('addSessionNote', 'API\sessionNoteApiController@store');
Route::post('deleteSessionNote', 'API\sessionNoteApiController@destroy');
Route::post('editSessionNote', 'API\sessionNoteApiController@edit');
Route::post('changeNoteStatus', 'API\sessionNoteApiController@changeNoteStatus');

//Cases Attachment Actions
Route::post('caseAttachment', 'API\attachmentApiController@index');
