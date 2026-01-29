<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpAddressToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('sender_user_id');
            $table->decimal('recaptcha_score', 3, 2)->nullable()->after('ip_address');
            $table->index('ip_address');
            $table->index('recaptcha_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['ip_address']);
            $table->dropIndex(['recaptcha_score']);
            $table->dropColumn(['ip_address', 'recaptcha_score']);
        });
    }
}
