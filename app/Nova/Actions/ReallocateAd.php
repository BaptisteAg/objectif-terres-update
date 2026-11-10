<?php

namespace App\Nova\Actions;

use App\Models\AttributionAd;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class ReallocateAd extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Réattribuer à un utilisateur';

    /**
     * Perform the action on the given models.
     *
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $new_user_id = $fields->new_user_id;
        $old_user_ids = $users->pluck('id')->toArray();

        $query = AttributionAd::whereIn('user_moderator_id', $old_user_ids)
            ->where('ad_status_id', 2);

        // Get ad IDs before update for thread handling
        $adIds = $query->pluck('ad_id');

        $query->update(['user_moderator_id' => $new_user_id]);

        // Update thread participants: add new moderator, remove old moderators
        $threads = Thread::whereIn('ad_id', $adIds)->get();
        foreach ($threads as $thread) {
            // Add new user if not already present
            if (! $thread->users()->where('users.id', $new_user_id)->exists()) {
                $thread->users()->attach($new_user_id);
            }
            // Remove old users from thread
            $thread->users()->detach($old_user_ids);
        }

        return Action::message('La réattribution à été effectuée avec succès!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $users = User::whereIn('role', [1, 3, 4])
            ->get()
            ->concat(
                User::where('role', 2)
                    ->whereHas('userPermissions', function ($query) {
                        $query->where('permission', 1);
                    })->get()
            )
            ->sortBy('name')
            ->keyBy('id')
            ->map(function (User $user) {
                return $user->name.' '.$user->first_name.' ('.$user->email.')';
            });

        return [
            Select::make('Utilisateur', 'new_user_id')->options($users),
        ];
    }
}
