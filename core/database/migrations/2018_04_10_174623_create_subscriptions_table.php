<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('invoice_id', 36)->index('subscriptions_invoice_id_foreign');
			$table->string('billingcycle');
			$table->date('nextduedate');
			$table->enum('status', array('1','0'))->default('1')->comment('0:cancelled,1:active');
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
		Schema::drop('subscriptions');
	}

}
