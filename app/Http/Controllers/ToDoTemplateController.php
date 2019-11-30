<?php

namespace App\Http\Controllers;

use App\TodoTemplate;
use App\Transformers\TodoTemplateTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoTemplateController extends ApiController
{
	protected $todoTemplateTransformer;
	private $_MAX_PER_PAGE = 20;

	function __construct(TodoTemplateTransformer $todoTemplateTransformer)
	{
		$this->todoTemplateTransformer = $todoTemplateTransformer;
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
		$todo_templates = TodoTemplate::paginate($limit);
		return $this->respondWithPagination($todo_templates, [
			'data' => $this->todoTemplateTransformer->transformCollection($todo_templates->all()),
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
		$user = auth()->user();
		$userRole = $user->role->role;
		if ($userRole !== 'admin' && $userRole !== 'chief_accountant') {
			return $this->respondNotEnoughRights();
		}
		$validator = Validator::make($request->all(), [
			'todo_template' => ['required', 'string', 'max:255', 'min: 1', 'unique:todo_templates,todo_template']
			// 'role_id'  => ['exists:roles,id'],
		]);

		if ($validator->fails()) {
			return $this->respondInvalidInput($validator->errors()->toArray());
		}

		$todoTemplate = TodoTemplate::create($validator->validated());

		return $this->respondSuccessCreation($this->todoTemplateTransformer->transform($todoTemplate));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\TodoTemplate  $toDoTemplate
	 * @return \Illuminate\Http\Response
	 */
	public function show(TodoTemplate $toDoTemplate)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\TodoTemplate  $toDoTemplate
	 * @return \Illuminate\Http\Response
	 */
	public function edit(TodoTemplate $toDoTemplate)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\TodoTemplate  $toDoTemplate
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, TodoTemplate $toDoTemplate)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\TodoTemplate  $toDoTemplate
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(TodoTemplate $toDoTemplate)
	{
		//
	}
}
