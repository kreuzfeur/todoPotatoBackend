<?php

use App\Defendant;
use Illuminate\Database\Seeder;

class DefendantsTableSeeder extends Seeder
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
			Defendant::create([
				'name' => $faker->unique()->name
			]);
		}
	}
}
