<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_settings', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('protocol');
			$table->string('smtp_host');
			$table->string('smtp_username');
			$table->string('smtp_password');
			$table->string('smtp_port');
			$table->string('from_email');
			$table->string('mailgun_domain');
			$table->string('mailgun_secret');
			$table->string('mandrill_secret');
			$table->string('from_name');
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
		Schema::drop('email_settings');
	}

}
