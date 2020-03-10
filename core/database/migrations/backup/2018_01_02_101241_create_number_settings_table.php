<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNumberSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('number_settings', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('invoice_number');
			$table->string('client_number');
			$table->string('estimate_number');
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
		Schema::drop('number_settings');
	}

}
