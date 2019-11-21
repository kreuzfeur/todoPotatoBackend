<?php

namespace App\Http\Controllers;

use App\ToDo;
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
		// admin видит все таски
		if ($user->role === 'admin') {
			$todos = ToDo::paginate($limit);
			return $this->respondWithPagination($todos, [
				'data' => $this->todoTransformer->transformCollection($todos->all()),
			]);
		}

		// не админ видит только свои
		$todos = ToDo::where('user_id', $user->id)->paginate($limit);
		return $this->respondWithPagination($todos, [
			'data' => $this->todoTransformer->transformCollection($todos->all()),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
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
			'todo' => ['required', 'string', 'max:255', 'min: 1']
		]);

		if ($validator->fails()) {
			return $this->respondInvalidInput($validator->errors()->toArray());
		}
		$user = auth()->user();

		$todo = $user->todos()->create($validator->validated());

		return $this->respondSuccessCreation($this->todoTransformer->transform($todo));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ToDo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$todo = ToDo::find($id);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ToDo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ToDo $toDo)
	{
		//
		dd('edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ToDo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, ToDo $toDo)
	{
		//
		dd('update');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ToDo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ToDo $toDo)
	{
		//
	}
}
