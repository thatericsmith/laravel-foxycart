<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table){
			$table->increments('id');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->string('role')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
			$table->string('country')->nullable();
			$table->string('company')->nullable();
			$table->string('phone')->nullable();
			$table->string('foxycart_id')->nullable();
			$table->string('subscription_token')->nullable();
			$table->tinyInteger('subscription_active')->default(0);
			$table->string('last_four',4)->nullable();
			$table->string('exp_month',2)->nullable();
			$table->string('exp_year',4)->nullable();
			$table->timestamp('subscription_ends_at')->nullable();
			$table->rememberToken();
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
