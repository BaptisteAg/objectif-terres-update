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
    public $tableName = 'locationable_users';

    /**
     * Run the migrations.
     *
     * @table locationable_users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('locationable_user_id');
            $table->string('locationable_user_type');

            $table->index(['locationable_user_type'], 'ix_locationable_user_2');
            $table->index(['locationable_user_id'], 'ix_locationable_user_1');

            $table->index(['user_id'], 'fk_locationable_users_1');
            $table->timestamps();

            $table->foreign('user_id', 'fk_locationable_users_1')
                ->references('id')->on('users')
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
        Schema::dropIfExists($this->tableName);
    }
};
