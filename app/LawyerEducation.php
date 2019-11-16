<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawyerEducation extends Model
{
	protected $table = "lawyer_educations";
	protected $fillable = ['name'];

	public function payment() {
		return $this->belongsToMany(Payment::class);
	}
}
