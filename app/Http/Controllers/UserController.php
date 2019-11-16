<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends ApiController
{
	/**
	 * Login user and return the user if successful.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		if (Auth::attempt(['name' => request('name'), 'password' => request('password')])) {
			$token = Str::random(80);
			$user = Auth::user();
			$user->forceFill([
				'api_token' =>  Hash::make($token)
			])->save();
			return $this->respondSuccessLogin($user, $token);
		} else {
			return $this->respondFaildLogin();
		}
	}

	/**
	 * Register a new user and return the user if successful.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function register(Request $request)
	{
		$input = $request->all();
		$validator = RegisterController::validator($request->all());
		if ($validator->fails()) {
			return $this->respondInvalidRegistration($validator->errors());
		}
		$token = Str::random(80);
		$user = RegisterController::create($input, $token);

		return $this->respondSuccessRegistration($user, $token);
	}
}
