<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     *
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
            $table->text('content')->nullable();
            $table->unsignedInteger('thread_id');
            $table->unsignedInteger('sender_user_id');

            $table->timestamps();

            $table->foreign('sender_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('thread_id')
                ->references('id')
                ->on('threads')
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
};
