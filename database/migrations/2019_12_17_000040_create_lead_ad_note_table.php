<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadAdNoteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lead_ad_note';

    /**
     * Run the migrations.
     * @table lead_ad_note
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content')->nullable();
            $table->string('sf_user_id')->nullable();
            $table->string('contact_name')->nullable();
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
