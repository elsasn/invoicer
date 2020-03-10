<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('invoice_id', 36)->index('payments_invoice_id_foreign');
			$table->date('payment_date');
			$table->float('amount', 15);
			$table->text('notes', 65535);
			$table->string('method', 36)->index('payments_method_foreign');
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
		Schema::drop('payments');
	}

}
