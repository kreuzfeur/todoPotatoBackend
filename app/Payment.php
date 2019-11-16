<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	public function lawyer() {
		return $this->belongsTo(Lawyer::class);
	}
	public function lawyerEducation() {
		return $this->belongsTo(LawyerEducation::class);
	}
	public function defendant() {
		return $this->belongsTo(Defendant::class);
	}
	public function judge() {
		return $this->belongsTo(Judge::class);
	}
	public function type() {
		return $this->belongsTo(Type::class);
	}
}
