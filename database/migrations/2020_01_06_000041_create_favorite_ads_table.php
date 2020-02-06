<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'favorite_ads';

    /**
     * Run the migrations.
     * @table favorite_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
			$table->unsignedInteger('ad_id');


            $table->index(["ad_id"], 'fk_favorite_ads_1');
            $table->index(["user_id"], 'ix_favorite_ads_user_id');

			$table->foreign('ad_id', 'fk_favorite_ads_1')
				->references('id')->on('ads')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->foreign('user_id','ix_favorite_ads_user_id' )
				->references('id')
				->on('users')
				->onDelete('cascade');

            $table->timestamps();
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
