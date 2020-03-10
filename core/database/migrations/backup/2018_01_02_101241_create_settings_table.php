<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('address1');
			$table->string('address2');
			$table->string('city');
			$table->string('state');
			$table->string('postal_code');
			$table->string('country');
			$table->string('contact');
			$table->string('vat');
			$table->string('website');
			$table->string('logo');
			$table->string('favicon');
			$table->string('date_format');
			$table->string('thousand_separator');
			$table->string('decimal_separator');
			$table->string('decimals');
			$table->string('purchase_code', 250);
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
		Schema::drop('settings');
	}

}
