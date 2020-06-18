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
        Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('id');
			$table->string('sf_id')->nullable();
			$table->string('name');
			$table->string('first_name');
			$table->string('phone')->nullable();
			$table->string('street')->nullable();
			$table->string('city')->nullable();
			$table->integer('civility')->nullable();
			$table->integer('profile')->nullable();
			$table->string('other_profile')->nullable();
			$table->boolean('accept_communication')->default(0);
			$table->boolean('accept_share_contact_infos')->default(0);
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->unsignedSmallInteger('country_id')->nullable();
			$table->unsignedInteger('zip_code_id')->nullable();
			$table->unsignedInteger('role')->default(0);
			$table->softDeletes();
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
