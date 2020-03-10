<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstimateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estimate_items', function(Blueprint $table)
		{
			$table->foreign('estimate_id')->references('uuid')->on('estimates')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('tax_id')->references('uuid')->on('tax_settings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estimate_items', function(Blueprint $table)
		{
			$table->dropForeign('estimate_items_estimate_id_foreign');
			$table->dropForeign('estimate_items_tax_id_foreign');
		});
	}

}
