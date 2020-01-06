<?php

use Illuminate\Database\Seeder;

class UserToUserMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\UserToUserMessage::class, 10)->create();
    }
}
