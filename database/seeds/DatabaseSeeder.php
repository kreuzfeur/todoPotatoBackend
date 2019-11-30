<?php

use App\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);

		// $this->call(DefendantsTableSeeder::class);
		// $this->call(JudgesTableSeeder::class);
		// $this->call(LawyerEducationsTableSeeder::class);
		// $this->call(LawyersTableSeeder::class);
		// $this->call(TypesTableSeeder::class);

		// $this->call(PaymentsTableSeeder::class);
		$this->call(ToDoTemplatesTableSeeder::class);
		$this->call(UnitsTableSeeder::class);
		$this->call(TodoTableSeeder::class);
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
