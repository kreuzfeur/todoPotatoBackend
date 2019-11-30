<?php

use App\TodoTemplate;
use Illuminate\Database\Seeder;

class ToDoTemplatesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TodoTemplate:: truncate();
		TodoTemplate::create(['todo_template' => 'Пахота']);
		TodoTemplate::create(['todo_template' => 'Чизелевание']);
		TodoTemplate::create(['todo_template' => 'Дискование после кукурузы']);
		TodoTemplate::create(['todo_template' => 'Дискование после картофеля']);
	}
}
