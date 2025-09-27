<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDataValuesTable extends Migration
{
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $tableName = 'project_data_values';

	/**
	 * Run the migrations.
	 * @table project_data_keys
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('project_data_key_id');
			$table->string('value');
			$table->timestamps();

			$table->index(["project_data_key_id"], 'fk_1');

			$table->foreign('project_data_key_id', 'fk_1')
				->references('id')
				->on('project_data_keys')
				->onDelete('cascade');
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
