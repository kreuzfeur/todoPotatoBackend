<?php

use App\Judge;
use Illuminate\Database\Seeder;

class JudgesTableSeeder extends Seeder
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
			Judge::create([
				'name' => $faker->unique()->name
			]);
		}
	}
}
