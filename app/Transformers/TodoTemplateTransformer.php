<?php

namespace App\Transformers;

class TodoTemplateTransformer extends Transformer
{
	public function transform($todoTemplate)
	{
		$todoTemplate = $todoTemplate->toArray();
		// dd($todo);
		return [
			'id' => $todoTemplate['id'],
			'todo_template' => $todoTemplate['todo_template'],
		];
	}
}
