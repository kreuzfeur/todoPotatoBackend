<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
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
			Type::create([
				'name' => $faker->unique()->name
			]);
		}
	}
}
