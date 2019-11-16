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
			$token = $this->getToken();
			$user = Auth::user();
			$user->forceFill([
				'api_token' => $token['tokenHash']
			])->save();
			return $this->respondSuccessLogin($user, $token['token']);
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
		$token = $this->getToken();
		$user = RegisterController::create($input, $token['tokenHash']);

		return $this->respondSuccessRegistration($user, $token['token']);
	}

	private function getToken() {
		$token = Str::random(80);
		$tokenHash = hash('sha256', $token);
		return [
			'token' => $token,
			'tokenHash' => $tokenHash,
		];
	}
}
