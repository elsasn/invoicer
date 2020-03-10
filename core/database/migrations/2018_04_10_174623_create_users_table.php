<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->string('username')->unique();
			$table->string('password', 60);
			$table->string('photo')->nullable();
			$table->string('role_id', 36)->index('users_role_id_foreign');
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('users');
	}

}
