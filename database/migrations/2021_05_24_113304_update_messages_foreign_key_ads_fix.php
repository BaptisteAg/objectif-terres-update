<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_sender_user_id_foreign');
            $table->unsignedInteger('sender_user_id')->nullable()->change();
            $table->foreign('sender_user_id', 'messages_sender_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_sender_user_id_foreign');
        });
    }
};
