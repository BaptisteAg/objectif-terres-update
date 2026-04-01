<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEducationLevelsChangeNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only update if records exist (they might not in test databases)
        $level1 = \App\Models\EducationLevel::find(1);
        if ($level1) $level1->update(['name' => 'Diplôme agricole niveau III (BEPA)']);

        $level2 = \App\Models\EducationLevel::find(2);
        if ($level2) $level2->update(['name' => 'Diplôme agricole niveau IV (BPREA, BAC)']);

        $level3 = \App\Models\EducationLevel::find(3);
        if ($level3) $level3->update(['name' => 'Diplôme agricole niveau V (BTSA, DUT)']);

        $level4 = \App\Models\EducationLevel::find(4);
        if ($level4) $level4->update(['name' => 'Diplôme agricole niveau VI (Licence pro)']);

        $level5 = \App\Models\EducationLevel::find(5);
        if ($level5) $level5->update(['name' => 'Diplôme agricole niveau VII ou plus (Master, Ingénieur, Doctorat, etc.)']);
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
}
