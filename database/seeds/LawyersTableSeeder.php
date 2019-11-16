<?php

use App\Lawyer;
use Illuminate\Database\Seeder;

class LawyersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create();

		for ($i = 0; $i < 100; $i++) {
			Lawyer::create([
				'name' => $faker->unique()->name
			]);
		}
	}
}
