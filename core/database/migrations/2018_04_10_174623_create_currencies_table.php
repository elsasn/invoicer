<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('name');
			$table->string('code', 10)->index();
			$table->string('symbol', 25);
			$table->string('format', 50);
			$table->string('exchange_rate');
			$table->boolean('active')->default(0);
			$table->boolean('default_currency')->default(0);
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
		Schema::drop('currencies');
	}

}
