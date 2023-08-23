<?php

namespace App\Nova\Actions;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use LaravelIdea\Helper\App\Models\_IH_User_C;

class ReallocateModeratorAds extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Reattribuer les annonces';

    protected Collection|array|_IH_User_C|\Illuminate\Database\Eloquent\Collection $availableModerators;

    public function __construct()
    {
        $this->availableModerators = User::whereRole(1)
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->map(function (User $user) {
                return $user->name . ' ' . $user->first_name . ' (' . $user->email . ')';
            });

        $this
            ->showOnTableRow()
            ->confirmText('Êtes-vous sûr de vouloir réaffecter les annonces ce modérateur ?')
            ->confirmButtonText('Oui')
            ->cancelButtonText("Non");
    }

    public function forUser(?User $user): self
    {
        if (!$user || $user->role != 1) {
            return $this;
        }
        $static = clone $this;
        $static->availableModerators = (clone $static->availableModerators)->forget($user->id);
        return $static;
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $moderators = $users->filter(function (User $user) {
            return $user->role == 1;
        });

        if (!$moderators->count()) {
            return Action::danger('Veuillez sélectionner au moins un modérateur.');
        }

        $new_moderator_id = $fields->new_moderator_id;
        $query = AttributionAd::where('user_moderator_id', $moderators->pluck("id"))
            ->whereIn('ad_status_id', [AdStatus::PENDING_ID, AdStatus::PENDING_MODERATION_STATUS_ID, AdStatus::APPROVE_ID, AdStatus::REFUSE_ID]);

        $count = $query->count();
        $query->update(["user_moderator_id" => $new_moderator_id]);

        return Action::message($count . ' annonces ont été réattribuées avec succès ! Attention, si le modérateur d\'origine n\'est pas supprimé, il peut être à nouveau choisi dans le processus d\'attribution automatique.');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Transférer les annonces à ', 'new_moderator_id')
                ->options($this->availableModerators)
                ->help('Attention, si le modérateur d\'origine n\'est pas supprimé, il peut être à nouveau choisi dans le processus d\'attribution automatique.'),
        ];
    }
}
