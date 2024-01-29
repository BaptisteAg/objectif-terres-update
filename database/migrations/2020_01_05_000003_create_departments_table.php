<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $tableName = 'departments';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
            $table->string('region_code');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug');

			$table->foreign('region_code')
				->references('code')->on('regions');

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
