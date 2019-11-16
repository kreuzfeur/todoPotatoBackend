<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LawyerEducationsTable extends Migration
{
	public function up()
	{
		Schema::create('lawyer_educations', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('lawyer_educations');
	}
}
