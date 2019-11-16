<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	protected $fillable = ['name'];

	public function payment() {
		return $this->belongsToMany(Payment::class);
	}
}
