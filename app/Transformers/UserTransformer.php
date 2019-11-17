<?php

namespace App\Transformers;

use App\User;

class UserTransformer extends Transformer
{
	public function transform($user)
	{
		// $userArr = $user->toArray();
		// dd($userArr->role());
		return [
			'username' => $user->username,
			'role' => $user->role->role,
			'updated_at' => $user->updated_at,
			'created_at' => $user->created_at,
		];
	}
}
