<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $tableName = 'cities';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('department_code');
				$table->string('insee_code');
				$table->string('zip_code');
				$table->string('name');
				$table->string('slug');
				$table->double('gps_lat',16, 14 );
				$table->double('gps_lng', 17, 14);

				$table->foreign('department_code')
					->references('code')->on('departments')
					->onDelete('cascade')
					->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
