<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
	protected $fillable = ['name'];

	public function payment() {
		return $this->belongsToMany(Payment::class);
	}
}
