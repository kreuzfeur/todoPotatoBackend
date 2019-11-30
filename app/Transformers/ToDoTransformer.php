<?php

namespace App\Transformers;

class ToDoTransformer extends Transformer
{
	public function transform($todo)
	{
		$todoArr = $todo->toArray();
		$unitTransformer = new UnitTransformer;
		$userTransformer = new UserTransformer;
		// dd($todo);
		return [
			'id' => $todoArr['id'],
			'volume' => (float)$todoArr['volume'],
			'unit' => $unitTransformer->transform($todo->unit),
			'todo' => $todo->todoTemplate->todo_template,
			'additional_info' => key_exists('additional_info', $todoArr) ? $todoArr['additional_info'] : '',
			'creater' => $userTransformer->transform($todo->createrUser),
			'doer' => $userTransformer->transform($todo->doerUser),
			'created_at' => $todoArr['created_at'],
			'updated_at' => $todoArr['updated_at'],
		];
	}
}
