<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends ApiController
{
	protected $userTransformer;
	private $_MAX_PER_PAGE = 10;

	function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

	/**
	 * Login user and return the user if successful.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
			$token = $this->getToken();
			$user = Auth::user();
			$user->forceFill([
				'api_token' => $token['tokenHash']
			])->save();
			return $this->respondSuccessLogin($this->userTransformer->transform($user), $token['token']);
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
		$user = auth()->user();
		if ($user->role->role !== 'admin') {
			return $this->respondNotEnoughRights();
		}

		$input = $request->all();
		$validator = RegisterController::validator($input);
		if ($validator->fails()) {
			return $this->respondInvalidRegistration($validator->errors());
		}
		$token = $this->getToken();
		$user = RegisterController::create($input, $token['tokenHash']);

		return $this->respondSuccessRegistration($this->userTransformer->transform($user), $token['token']);
	}

	private function getToken()
	{
		$token = Str::random(80);
		$tokenHash = hash('sha256', $token);
		return [
			'token' => $token,
			'tokenHash' => $tokenHash,
		];
	}
}
