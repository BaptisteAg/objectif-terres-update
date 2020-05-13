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
			$table->unsignedInteger('ad_id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('project_data_key_id')->nullable();
			$table->text('value');
			$table->string('contact_name')->nullable();

            $table->index(["project_data_key_id"], 'fk_lead_ad_notes_1_idx');
            $table->index(["user_id"], 'fk_lead_ad_notes_2_idx');
            $table->index(["ad_id"], 'fk_lead_ad_notes_3_idx');

            $table->timestamps();

			$table->foreign('project_data_key_id','fk_lead_ad_notes_1_idx' )
				->references('id')
				->on('project_data_keys')
				->onDelete('set null');

			$table->foreign('user_id','fk_lead_ad_notes_2_idx' )
				->references('id')
				->on('users')
				->onDelete('cascade');

            $table->foreign('ad_id', 'fk_lead_ad_notes_3_idx')
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
