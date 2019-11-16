<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->date('date');
			$table->float('cash')->unsigned();

			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->bigInteger('lawyer_id')->unsigned();
			$table->foreign('lawyer_id')->references('id')->on('lawyers')->onDelete('cascade');

			$table->bigInteger('lawyer_education_id')->unsigned();
			$table->foreign('lawyer_education_id')->references('id')->on('lawyer_educations')->onDelete('cascade');

			$table->bigInteger('defendant_id')->unsigned();
			$table->foreign('defendant_id')->references('id')->on('defendants')->onDelete('cascade');

			$table->bigInteger('judge_id')->unsigned();
			$table->foreign('judge_id')->references('id')->on('judges')->onDelete('cascade');

			$table->bigInteger('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');

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
		Schema::dropIfExists('lawyers');
	}
}
