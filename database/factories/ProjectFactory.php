<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\SupportStage;
use App\Models\SupportState;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'support_stage_id' => SupportStage::FIRST_CONTACT_ID,
            'support_state_id' => SupportState::TO_HANDLE_ID,
        ];
    }
}
