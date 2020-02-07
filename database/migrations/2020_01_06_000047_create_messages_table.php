<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $tableName = 'messages';

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
			$table->text('content');
			$table->boolean('is_between_pp')->default(0);
			$table->unsignedInteger('sender_user_id');
			$table->unsignedInteger('receiver_user_id')->nullable();
			$table->unsignedInteger('ad_id')->nullable();

			$table->timestamps();

			$table->foreign('sender_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('receiver_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('ad_id')
				->references('id')->on('ads')
				->onDelete('restrict')
				->onUpdate('restrict');
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
