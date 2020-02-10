<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ads';

    /**
     * Run the migrations.
     * @table ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_pp_id');
            $table->unsignedInteger('user_admin_id')->nullable();
            $table->boolean('is_draft');
            $table->string('about_content', 1000)->nullable();
            $table->string('about_project_content', 1000)->nullable();
            $table->unsignedInteger('attribution_ad_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();

            $table->index(["attribution_ad_id"], 'fk_ads_1_idx');

            $table->index(["user_admin_id"], 'iix_ads_user_admin_id');

            $table->index(["user_pp_id"], 'ix_ads_user_lead_id');

            $table->index(["project_id"], 'fk_ads_2_idx');
            $table->timestamps();

			$table->foreign('user_admin_id','iix_ads_user_admin_id' )
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('user_pp_id','ix_ads_user_lead_id' )
				->references('id')
				->on('users')
				->onDelete('cascade');

            $table->foreign('attribution_ad_id', 'fk_ads_1_idx')
                ->references('id')->on('attribution_ads')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('project_id', 'fk_ads_2_idx')
                ->references('id')->on('projects')
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
