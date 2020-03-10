<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoiceItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_items', function(Blueprint $table)
		{
			$table->foreign('invoice_id')->references('uuid')->on('invoices')->onUpdate('CASCADE')->onDelete('CASCADE');
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
		Schema::table('invoice_items', function(Blueprint $table)
		{
			$table->dropForeign('invoice_items_invoice_id_foreign');
			$table->dropForeign('invoice_items_tax_id_foreign');
		});
	}

}
