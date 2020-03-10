<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locales', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('locale_name');
			$table->string('short_name');
			$table->string('flag');
			$table->enum('default', array('1','0'))->default('0');
			$table->integer('status')->default(0);
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
		Schema::drop('locales');
	}

}
