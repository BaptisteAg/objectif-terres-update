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
            $table->string('sf_owner_id')->nullable();
            $table->string('sf_admin_id');
            $table->boolean('to_call_back')->nullable();
            $table->text('short_description')->nullable();
            $table->unsignedInteger('ad_status_id');
            $table->unsignedInteger('pp_type_id')->nullable();
            $table->unsignedInteger('refusal_type_id')->nullable();
            $table->timestamp('archived_at')->nullable();

            $table->index(["ad_status_id"], 'fk_attribution_ads_1_idx');

            $table->index(["sf_owner_id"], 'ix_attribution_ad_sf_owner_id');

            $table->index(["refusal_type_id"], 'fk_attribution_ads_4_idx');

            $table->index(["sf_admin_id"], 'ix_attribution_ad_sf_admin_id');

            $table->index(["pp_type_id"], 'fk_attribution_ads_2_idx');
            $table->timestamps();


            $table->foreign('ad_status_id', 'fk_attribution_ads_1_idx')
                ->references('id')->on('ad_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('pp_type_id', 'fk_attribution_ads_2_idx')
                ->references('id')->on('pp_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('refusal_type_id', 'fk_attribution_ads_4_idx')
                ->references('id')->on('refusal_types')
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
