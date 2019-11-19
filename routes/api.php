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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register')->middleware('auth:api');
Route::get('roles', 'RoleController@index')->middleware('auth:api');
Route::get('users', 'UserController@index')->middleware('auth:api');

Route::resource('/payments', 'PaymentController', [
	'only' => [
		'index', 'store'
	]
]);

Route::resource('todo', 'ToDoController')->middleware('auth:api');
