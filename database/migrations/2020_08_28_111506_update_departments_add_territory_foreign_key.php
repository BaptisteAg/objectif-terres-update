<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDepartmentsAddTerritoryForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('departments', function (Blueprint $table) {
			$table->unsignedInteger('territory_id')->nullable();
			$table->timestamps();
			$table->index(["territory_id"], 'fk_territory_id_idx');

			$table->foreign('territory_id', 'fk_territory_id_idx')
				->references('id')->on('territories')
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
		Schema::table('departments', function (Blueprint $table) {
			$table->removeColumn('territory_id');
		});
    }
}
