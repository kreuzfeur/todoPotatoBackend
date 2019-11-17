<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
	protected $fillable = ['todo'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function getRouteKeyName()
	{
		return 'id';
	}
}
