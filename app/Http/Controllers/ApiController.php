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

	public function respondNotFound($message = 'Не найдено')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondInvalidRegistration($message)
	{
		return $this->setStatusCode(401)->respondWithError($message);
	}

	public function respondNotEnoughRights()
	{
		return $this->setStatusCode(403)->respondWithError('Недостаточно прав');
	}

	public function respondSuccessRegistration($user, $token)
	{
		return $this->setStatusCode(201)->respond(
			[
				'user' => $user,
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

	public function respondSuccessLogin($user, $token)
	{
		return $this->setStatusCode(200)->respond(
			[
				'user' => $user,
				'token' => $token
			]
		);
	}

	public function respondFaildLogin($message = 'Неверное имя пользователя или пароль')
	{
		return $this->setStatusCode(400)->respondWithError($message);
	}

	public function respondInvalidInput($message = 'Неверные данные')
	{
		return $this->setStatusCode(400)->respondWithError($message);
	}

	public function respondInternalError($message = 'Внутренняя ошибка')
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
			'message' => 'Успешно создано!'
		]);
	}

	public function respond($data, $headers = ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'])
	{
		return Response::json($data, $this->getStatusCode(), $headers, JSON_UNESCAPED_UNICODE);
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
