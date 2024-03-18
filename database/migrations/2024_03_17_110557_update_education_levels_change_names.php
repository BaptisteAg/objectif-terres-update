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
        \App\Models\EducationLevel::find(1)->update(['name' => 'Diplôme agricole niveau III (BEPA)']);
        \App\Models\EducationLevel::find(2)->update(['name' => 'Diplôme agricole niveau IV (BPREA, BAC)']);
        \App\Models\EducationLevel::find(3)->update(['name' => 'Diplôme agricole niveau V (BTSA, DUT)']);
        \App\Models\EducationLevel::find(4)->update(['name' => 'Diplôme agricole niveau VI (Licence pro)']);
        \App\Models\EducationLevel::find(5)->update(['name' => 'Diplôme agricole niveau VII ou plus (Master, Ingénieur, Doctorat, etc.)']);
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
