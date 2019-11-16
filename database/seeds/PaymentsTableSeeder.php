<?php

use App\Defendant;
use App\Judge;
use App\Lawyer;
use App\LawyerEducation;
use App\Payment;
use App\Type;
use App\User;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create();

		$usersIds = User::get()->pluck('id');
		$defendantsIds = Defendant::get()->pluck('id');
		$judgesIds = Judge::get()->pluck('id');
		$lawyerEducationsIds = LawyerEducation::get()->pluck('id');
		$lawyersIds = Lawyer::get()->pluck('id');
		$typesIds = Type::get()->pluck('id');

		for ($i = 0; $i < 1000; $i++) {
			Payment::create([
				'date' => $faker->date(),
				'cash' => $faker->numberBetween(0, 1000000),
				'user_id' => $faker->randomElement($usersIds),
				'defendant_id' => $faker->randomElement($defendantsIds),
				'judge_id' => $faker->randomElement($judgesIds),
				'lawyer_education_id' => $faker->randomElement($lawyerEducationsIds),
				'lawyer_id' => $faker->randomElement($lawyersIds),
				'type_id' => $faker->randomElement($typesIds),
			]);
		}
	}
}
