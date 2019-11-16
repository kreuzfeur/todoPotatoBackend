<?php

use App\LawyerEducation;
use Illuminate\Database\Seeder;

class LawyerEducationsTableSeeder extends Seeder
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
			LawyerEducation::create([
				'name' => $faker->unique()->name
			]);
		}
	}
}
