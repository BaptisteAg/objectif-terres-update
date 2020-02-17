<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdNotesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ad_notes';

    /**
     * Run the migrations.
     * @table ad_notes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content');
            $table->unsignedInteger('user_id');
            $table->string('contact_name')->nullable();
            $table->unsignedInteger('ad_id');

            $table->index(["user_id"], 'ix_lead_ad_note_user_id');

            $table->index(["ad_id"], 'fk_lead_ad_notes_1_idx');
            $table->timestamps();

			$table->foreign('user_id','ix_lead_ad_note_user_id' )
				->references('id')
				->on('users')
				->onDelete('cascade');

            $table->foreign('ad_id', 'fk_lead_ad_notes_1_idx')
                ->references('id')->on('ads')
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
}
