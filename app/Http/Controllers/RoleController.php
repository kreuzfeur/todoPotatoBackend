<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
	public function index()
	{

		$roles = Role::all();

		return $this->respond($roles);
	}
}
//tes