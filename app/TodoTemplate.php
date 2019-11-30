<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoTemplate extends Model
{
	protected $fillable = [
		'todo_template'
	];

	public function todo()
	{
		return $this->hasMany(Todo::class);
	}
}
