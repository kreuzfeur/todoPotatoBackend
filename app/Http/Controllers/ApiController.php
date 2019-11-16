<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
	protected $stausCode = 200;

	public function getStatusCode()
	{
		return $this->stausCode;
	}
	public function setStatusCode($statusCode)
	{
		$this->stausCode = $statusCode;
		return $this;
	}

	public function respondNotFound($message = 'Not found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondInvalidRegistration($message)
	{
		return $this->setStatusCode(401)->respondWithError($message);
	}

	public function respondSuccessRegistration(User $user, $token)
	{
		return $this->setStatusCode(201)->respond(
			[
				'user' => $user->toArray(),
				'token' => $token
			]
		);
	}

	public function respondSuccessCreation($message)
	{
		return $this->setStatusCode(201)->respond(
			$message
		);
	}

	public function respondSuccessLogin(User $user, $token)
	{
		return $this->setStatusCode(200)->respond(
			[
				'user' => $user->toArray(),
				'token' => $token
			]
		);
	}

	public function respondFaildLogin($message = 'Invalid email or password')
	{
		return $this->setStatusCode(400)->respondWithError($message);
	}

	public function respondInvalidInput($message = 'Invalid input data')
	{
		return $this->setStatusCode(400)->respondWithError($message);
	}

	public function respondInternalError($message = 'Internal Error')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}

	public function respondCreated()
	{
		return $this->setStatusCode(201)->respond([
			'message' => 'Lesson created'
		]);
	}

	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

	protected function respondWithPagination($collection, $data)
	{
		$dataRes = array_merge([
			'page' => $collection->currentPage(),
			'total_items' => $collection->total(),
			'total_pages' => ceil($collection->total() / $collection->perPage()),
			'page_size' => (int) $collection->perPage()
		], $data);

		return $this->respond($dataRes);
	}
}
