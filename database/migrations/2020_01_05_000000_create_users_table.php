<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $tableName = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists($this->tableName);

        Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('first_name');
			$table->string('phone')->nullable();
			$table->string('address');
			$table->string('city');
			$table->boolean('accept_communication');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->unsignedSmallInteger('country_id');
			$table->unsignedInteger('zip_code_id');
			$table->rememberToken();
			$table->timestamps();

			$table->index(["country_id"], 'fk_users_countries_1_idx');
			$table->foreign('country_id', 'fk_users_countries_1_idx')
				->references('id')->on('countries');

			$table->index(["zip_code_id"], 'fk_users_zip_code_2_idx');
			$table->foreign('zip_code_id', 'fk_users_zip_code_2_idx')
				->references('id')->on('cities');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
