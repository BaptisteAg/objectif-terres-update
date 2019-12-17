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
            $table->text('content')->nullable();
            $table->string('sf_sender_id')->nullable()->comment('id d\'une personne enregistrée dans Salesforce (membre de TdL ou non) en étant l\'auteur d\'un message');
            $table->unsignedInteger('ad_id')->nullable();

            $table->index(["ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('ad_id')
                ->references('id')->on('ads')
                ->onDelete('no action')
                ->onUpdate('no action');
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
