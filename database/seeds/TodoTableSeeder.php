<?php

use App\Todo;
use Illuminate\Database\Seeder;

class TodoTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Todo::truncate();
		$faker = \Faker\Factory::create();

		$todoTemplateIds = DB::table('todo_templates')->select()->pluck('id');
		$unitsIds = DB::table('units')->select()->pluck('id');
		$usersIds = DB::table('users')->select()->pluck('id');

		for ($i = 0; $i < 10; $i++) {
			Todo::create([
				// 'username' => $faker->unique()->firstName,
				// 'password' => $password,
				// 'role_id' => $faker->randomElement($roleIds)
				'volume' => $faker->randomFloat(3, 0, 3000),
				'unit_id' => $faker->randomElement($unitsIds),
				'todo_template_id' => $faker->randomElement($todoTemplateIds),
				'additional_info' => $faker->paragraph,
				'creater_user_id' => $faker->randomElement($usersIds),
				'doer_user_id' => $faker->randomElement($usersIds),
			]);
		}
	}
}
