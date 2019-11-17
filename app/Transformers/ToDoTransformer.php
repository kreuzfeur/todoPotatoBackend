<?php

namespace App\Transformers;

class ToDoTransformer extends Transformer
{
	public function transform($todo)
	{
		$todo = $todo->toArray();
		// dd($todo);
		return [
			'id' => $todo['id'],
			'todo' => $todo['todo'],
			'date' => $todo['updated_at'],
		];
	}
}
