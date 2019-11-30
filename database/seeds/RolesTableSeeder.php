<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('roles')->truncate();

		$faker = \Faker\Factory::create();

		DB::table('roles')->insert(['role' => 'admin']);
		DB::table('roles')->insert(['role' => 'chief_accountant']);
		DB::table('roles')->insert(['role' => 'worker']);
		DB::table('roles')->insert(['role' => 'manager']);
	}
}
