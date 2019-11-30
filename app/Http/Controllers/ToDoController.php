<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Transformers\ToDoTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends ApiController
{
	protected $todoTransformer;
	private $_MAX_PER_PAGE = 10;

	function __construct(ToDoTransformer $todoTransformer)
	{
		$this->todoTransformer = $todoTransformer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$limit = (int) $request->get('limit');
		if (!($limit > 0 && $limit <= $this->_MAX_PER_PAGE)) {
			$limit = $this->_MAX_PER_PAGE;
		}
		$user = auth()->user();
		$userRole = $user->role->role;

		// $from = date('2018-01-01');
		// $to = date('2018-05-02');
		// Reservation::whereBetween('reservation_from', [$from, $to])->get();

		// admin видит все таски
		if ($userRole === 'admin' || $userRole === 'chief_accountant') {
			$todos = Todo::paginate($limit);
			return $this->respondWithPagination($todos, [
				'data' => $this->todoTransformer->transformCollection($todos->all()),
			]);
		}

		// не админ видит только свои
		$todos = Todo::where('doer_user_id', $user->id)->paginate($limit);
		return $this->respondWithPagination($todos, [
			'data' => $this->todoTransformer->transformCollection($todos->all()),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			// 'todo' => ['required', 'string', 'max:255', 'min: 1']
			'volume' => ['required', 'between:0,99999999'],
			'unit_id' => ['required', 'exists:units,id'],
			'todo_template_id' => ['required', 'exists:todo_templates,id'],
			'additional_info' => ['string', 'max:255', 'min: 1'],
			// 'creater_user_id' => ['exists:users,id'],
			'doer_user_id' => ['exists:users,id'],
		]);

		if ($validator->fails()) {
			return $this->respondInvalidInput($validator->errors()->toArray());
		}
		// dd($validator->validated());
		$user = auth()->user();

		$userRole = $user->role->role;
		if ($userRole === 'worker' || $userRole === 'manager') { }

		$todo = Todo::create(array_merge(
			$validator->validated(),
			['creater_user_id' => $user->id]
		));

		return $this->respondSuccessCreation($this->todoTransformer->transform($todo));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Todo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$todo = Todo::find($id);
		if (!$todo) {
			return $this->respondNotFound('Запись не найдена');
		}
		$user = auth()->user();
		if ($user->id !== $todo->user_id && $user->role->role !== 'admin') {
			return $this->respondNotEnoughRights();
		}
		return $this->respond([
			'data' => $this->todoTransformer->transform($todo)
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Todo $toDo)
	{
		//
		dd('update');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Todo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Todo $toDo)
	{
		//
	}
}
