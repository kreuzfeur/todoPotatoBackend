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

// auth
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register')->middleware('auth:api');

// users
Route::get('users', 'UserController@index')->middleware('auth:api');
Route::put('users/{id}', 'UserController@update')->middleware('auth:api');
Route::delete('users/{id}', 'UserController@destroy')->middleware('auth:api');

// roles
Route::get('roles', 'RoleController@index')->middleware('auth:api');

// todo
Route::resource('todo', 'ToDoController', [
	'only' => [
		'index', 'store'
	]
])->middleware('auth:api');

//todo templates
Route::get('todo-templates', 'TodoTemplateController@index')->middleware('auth:api');
Route::post('todo-templates', 'TodoTemplateController@store')->middleware('auth:api');

//units
Route::get('units', 'UnitController@index')->middleware('auth:api');

// for lawyers payment
Route::resource('/payments', 'PaymentController', [
	'only' => ['index', 'store']
]);


// 404
Route::fallback(function () {
	return response()->json([
		'error' => ['message' => 'Not Found.']
	], 404);
});
