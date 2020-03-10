<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstimatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estimates', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('client_id', 36)->index('estimates_client_id_foreign');
			$table->string('estimate_no')->unique();
			$table->date('estimate_date');
			$table->string('currency');
			$table->text('notes', 65535);
			$table->text('terms', 65535);
			$table->timestamps();
		});
		// then I add the increment_num "manually"
        DB::statement('ALTER Table estimates add increment_num INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estimates');
	}

}
