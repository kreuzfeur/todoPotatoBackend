<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	public function todo() {
		return $this->hasMany(Todo::class);
	}
}
