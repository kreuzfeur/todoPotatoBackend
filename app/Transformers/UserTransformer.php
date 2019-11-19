<?php

namespace App\Transformers;

use App\User;

class UserTransformer extends Transformer
{
	public function transform($user)
	{
		$userArr = $user->toArray();
		return [
			'username' => $user['username'],
			'role' => $user->role->role,
			'updated_at' => $userArr['updated_at'],
			'created_at' => $userArr['created_at'],
		];
	}
}
