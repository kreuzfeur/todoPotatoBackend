<?php

namespace App\Http\Controllers;

use App\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends ApiController
{
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

		$todos = ToDo::paginate($limit);
		return $this->respondWithPagination($todos, [
			'data' => $this->paymentTransformer->transformCollection($todos->all()),
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

		return $this->respondSuccessCreation($todo->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ToDo  $toDo
	 * @return \Illuminate\Http\Response
	 */
	public function show(ToDo $toDo)
	{
		dd($toDo);
		// $lesson = Lesson::find($id);
		// if (!$lesson) {
		// 	return $this->respondNotFound('Lesson does not exist');
		// }
		// return $this->respond([
		// 	'data' => $this->lessonTransformer->transform($lesson)
		// ]);
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
