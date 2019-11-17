<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Let's clear the users table first
		User::truncate();

		$faker = \Faker\Factory::create();

		// Let's make sure everyone has the same password and 
		// let's hash it before the loop, or else our seeder 
		// will be too slow.
		$password = Hash::make('qwerty');

		User::create([
			'username' => 'admin',
			'password' => $password,
			'role_id' => 1
		]);
		User::create([
			'username' => 'user',
			'password' => $password,
			'role_id' => 2
		]);

		$roleIds = DB::table('roles')->select()->pluck('id');
		for ($i = 0; $i < 10; $i++) {
			User::create([
				'username' => $faker->unique()->firstName,
				'password' => $password,
				'role_id' => $faker->randomElement($roleIds)
			]);
		}
	}
}
