<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributionAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'attribution_ads';

    /**
     * Run the migrations.
     * @table attribution_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('to_call_back')->nullable();
            $table->string('sf_owner_id')->nullable();
            $table->string('sf_admin_id')->nullable();
            $table->text('short_description')->nullable();
            $table->string('ad_status')->nullable();
            $table->string('project_status')->nullable();
            $table->date('archive_date')->nullable();
            $table->unsignedInteger('lead_type_id')->nullable();
            $table->unsignedInteger('refusal_type_id')->nullable();

            $table->index(["refusal_type_id"]);

            $table->index(["lead_type_id"]);
            $table->nullableTimestamps();


            $table->foreign('lead_type_id')
                ->references('id')->on('lead_types')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('refusal_type_id')
                ->references('id')->on('refusal_types')
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
