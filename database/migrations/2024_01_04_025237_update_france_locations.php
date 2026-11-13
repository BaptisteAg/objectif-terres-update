<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Executes the SQLs scripts in the database/migrations/sql folder
        // but only regions, departments and cities
        $sqls = [
            'database/sql/regions.sql',
            'database/sql/departments.sql',
            'database/sql/cities.sql',
        ];

        foreach ($sqls as $sql) {
            $sql = file_get_contents(base_path($sql));
            DB::unprepared($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
