<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdMessagesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ad_messages';

    /**
     * Run the migrations.
     * @table ad_messages
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content');
            $table->string('sf_sender_id')->comment('id d\'une personne enregistrée dans Salesforce (membre de TdL ou non) en étant l\'auteur d\'un message');
            $table->unsignedInteger('ad_id');

            $table->index(["sf_sender_id"], 'ix_ad_message_sf_sender_id');

            $table->index(["ad_id"], 'fk_ad_messages_1_idx');
            $table->timestamps();


            $table->foreign('ad_id', 'fk_ad_messages_1_idx')
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
