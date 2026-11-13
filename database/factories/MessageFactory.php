<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;
use App\Models\Thread;
use App\Models\User;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(250),
            'sender_user_id' => User::all()->random(),
            'receiver_user_id' => User::all()->random(),
            'thread_id' => Thread::all()->random(),
        ];
    }
}
