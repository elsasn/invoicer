<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_items', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('invoice_id', 36)->index('invoice_items_invoice_id_foreign');
			$table->string('item_name');
			$table->text('item_description', 65535);
			$table->float('quantity');
			$table->float('price', 15);
			$table->string('tax_id', 36)->nullable()->index('invoice_items_tax_id_foreign');
			$table->integer('item_order');
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
		Schema::drop('invoice_items');
	}

}
