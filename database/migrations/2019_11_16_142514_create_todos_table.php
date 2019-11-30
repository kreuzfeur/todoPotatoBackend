<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToDosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('todos', function (Blueprint $table) {
			$table->bigIncrements('id');
			// $table->string('todo')->nullable()->default(null);

			$table->unsignedDecimal('volume', 8, 3);
			$table->bigInteger('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

			$table->bigInteger('todo_template_id')->unsigned();
			$table->foreign('todo_template_id')->references('id')->on('todo_templates')->onDelete('cascade');

			$table->string('additional_info')->nullable()->default(null);

			$table->bigInteger('creater_user_id')->unsigned();
			$table->foreign('creater_user_id')->references('id')->on('users')->onDelete('cascade');

			$table->bigInteger('doer_user_id')->unsigned();
			$table->foreign('doer_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('todos');
	}
}
