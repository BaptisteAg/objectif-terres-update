<?php

namespace App\Nova\Actions;

use App\Models\AttributionAd;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $new_user_id = $fields->new_user_id;
        AttributionAd::where('user_moderator_id', $users->pluck("id"))
            ->where('ad_status_id', 2)
            ->update(["user_moderator_id" => $new_user_id]);

        return Action::message('La réattribution à été effectuée avec succès!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $users = DB::table("users")->whereIn('role', [1,2,3,4])
            ->orderBy('name', 'asc')
            ->pluck('name','id');
        return [
            Select::make('Utilisateur','new_user_id')->options($users),
        ];
    }
}
