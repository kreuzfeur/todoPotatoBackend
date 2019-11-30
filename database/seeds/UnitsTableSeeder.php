<?php

use App\Unit;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Unit::create([
			'name' => 'Гектары',
			'short_name' => 'га',
			'type' => 'Площадь',
		]);
		Unit::create([
			'name' => 'Тонны',
			'short_name' => 'тн',
			'type' => 'Вес',
		]);
		Unit::create([
			'name' => 'Километры',
			'short_name' => 'км',
			'type' => 'Длина',
		]);
		Unit::create([
			'name' => 'Штуки',
			'short_name' => 'шт',
			'type' => 'Количество',
		]);
	}
}
