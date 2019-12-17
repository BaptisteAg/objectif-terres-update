<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentLeadAdNoteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'document_lead_ad_note';

    /**
     * Run the migrations.
     * @table document_lead_ad_note
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('lead_note_ad');

            $table->index(["document_id"]);

            $table->index(["lead_note_ad"]);
            $table->nullableTimestamps();


            $table->foreign('lead_note_ad')
                ->references('id')->on('lead_ad_note')
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
