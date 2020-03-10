<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenses', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('name');
			$table->string('vendor');
			$table->string('category_id');
			$table->date('expense_date');
			$table->float('amount', 15);
			$table->text('notes', 65535);
			$table->string('currency', 20);
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
		Schema::drop('expenses');
	}

}
