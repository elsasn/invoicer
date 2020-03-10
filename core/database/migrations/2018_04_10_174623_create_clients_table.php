<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('client_no');
			$table->string('name');
			$table->string('email');
			$table->string('password', 60);
			$table->string('address1');
			$table->string('address2');
			$table->string('city');
			$table->string('state');
			$table->string('postal_code');
			$table->string('country');
			$table->string('phone');
			$table->string('mobile');
			$table->string('website');
			$table->text('notes', 65535);
			$table->string('photo');
			$table->string('remember_token', 100);
			$table->timestamps();
		});
        // then I add the increment_num "manually"
        DB::statement('ALTER Table clients add increment_num INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
