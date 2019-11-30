<?php

namespace App\Transformers;

use App\User;

class UserTransformer extends Transformer
{
	public function transform($user)
	{
		$userArr = $user->toArray();
		return [
			'id' => $user['id'],
			'username' => $user['username'],
			'role' => $user->role,
			// 'updated_at' => $userArr['updated_at'],
			// 'created_at' => $userArr['created_at'],
		];
	}
}
