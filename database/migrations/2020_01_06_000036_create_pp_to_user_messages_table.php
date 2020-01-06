<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpToUserMessagesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'pp_to_user_messages';

    /**
     * Run the migrations.
     * @table pp_to_user_messages
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('sf_sender_id');
            $table->string('sf_receiver_id');
            $table->text('content');
            $table->unsignedInteger('ad_id');

            $table->index(["ad_id"], 'fk_lead_to_user_messages_1_idx');

            $table->index(["sf_sender_id"], 'ix_lead_to_user_message_sf_sender');

            $table->index(["sf_receiver_id"], 'ix_lead_to_user_message_sf_receiver');
            $table->timestamps();


            $table->foreign('ad_id', 'fk_lead_to_user_messages_1_idx')
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
