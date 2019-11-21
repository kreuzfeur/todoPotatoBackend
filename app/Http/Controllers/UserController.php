<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{
	protected $userTransformer;
	private $_MAX_PER_PAGE = 5;

	function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

	public function index(Request $request)
	{
		$limit = (int) $request->get('limit');
		if (!($limit > 0 && $limit <= $this->_MAX_PER_PAGE)) {
			$limit = $this->_MAX_PER_PAGE;
		}
		$user = auth()->user();
		if ($user->role->role === 'admin') {
			$users = User::paginate($limit);
			return $this->respondWithPagination($users, [
				// 'data' => $users->all(),
				'users' => $this->userTransformer->transformCollection($users->all()),
			]);
		}
		return $this->respondNotEnoughRights();
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

		// вернуть только сообщение об успехе
		return $this->respondSuccessCreation('Пользователь ' . $user->username . ' успешно создан!');
	}

	public function update(Request $request, $id)
	{
		$user = auth()->user();
		if ($user->role->role !== 'admin') {
			return $this->respondNotEnoughRights();
		}
		$validator = Validator::make($request->all(), [
			'role_id'  => ['exists:roles,id'],
			'password' => ['string', 'min:6', 'confirmed'],
		]);
		if ($validator->fails()) {
			return $this->respondInvalidRegistration($validator->errors());
		}
		$userUpdate = $validator->validated();
		if($userUpdate['password']) {
			$userUpdate['password'] = Hash::make($userUpdate['password']);
		}
		$updUser = User::find($id);
		if (!$updUser) {
			return $this->respondNotFound('Пользователь не найден');
		}
		$updUser->update($userUpdate);
		return $this->setStatusCode(200)->respond(['user' => $updUser]);
	}

	public function destroy($id)
	{
		$user = auth()->user();
		if ($user->role->role !== 'admin') {
			return $this->respondNotEnoughRights();
		}
		$delUser = User::find($id);
		if (!$delUser) {
			return $this->respondNotFound('Пользователь не найден');
		}
		if ($delUser->role->role === 'admin') {
			return $this->setStatusCode(400)->respondWithError('Нельзя удалить пользователя с правами администратора');
		}
		User::destroy($id);
		return $this->setStatusCode(204)->respond('Пользователь удален!');
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
