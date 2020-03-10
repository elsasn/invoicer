<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_settings', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->integer('start_number');
			$table->text('terms', 65535);
			$table->integer('due_days');
			$table->string('logo');
			$table->enum('show_status', array('0','1'))->default('1');
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
		Schema::drop('invoice_settings');
	}

}
