<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	protected $fillable = [
		'volume',
		'unit_id',
		'todo_template_id',
		'additional_info',
		'creater_user_id',
		'doer_user_id',
	];

	public function createrUser()
	{
		return $this->belongsTo(User::class);
	}

	public function doerUser()
	{
		return $this->belongsTo(User::class);
	}

	public function unit() {
		return $this->belongsTo(Unit::class);
	}

	public function todoTemplate() {
		return $this->belongsTo(TodoTemplate::class);
	}

	public function getRouteKeyName()
	{
		return 'id';
	}
}
