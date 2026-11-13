<?php

namespace App\Nova;

use App\Models\AdStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class AttributionAd extends Resource
{
    public static function label()
    {
        return 'Modérations';
    }

    public static function singularLabel()
    {
        return 'Modération';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AttributionAd::class;

    public function title(): string
    {
        $moderator = $this->userModerator ? ' - '.$this->userModerator->name.' '.$this->userModerator->first_name : 'Aucun modérateur';

        return '('.$this->ad?->id.')'.$this->ad?->title.$moderator;
    }

    public static $with = ['ad', 'userModerator'];

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'ads.id',
        'ads.title',
        'userModerator',
    ];

    public static function applySearch($query, $search)
    {
        return $query->orWhereHas('ad', function ($query) use ($search) {
            $query->where('title', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%");
        })->orWhereHas('userModerator', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")->orWhere('first_name', 'LIKE', "%$search%");
        })->orWhere('id', 'LIKE', "%$search%");
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $moderators = User::whereIn('role', [1, 3, 4])
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
            Text::make('ID', 'ad.id')->sortable()->readonly(),
            BelongsTo::make('Annonce', 'ad', Ad::class)->readonly(),
            // BelongsTo::make('Modérateur', 'userModerator', UserModerator::class),
            Select::make('Modérateur', 'user_moderator_id')->options($moderators),
            Badge::make('Statut', 'ad_status_id')
                ->map([
                    AdStatus::APPROVE_ID => 'success',
                    AdStatus::PENDING_ID => 'info',
                    AdStatus::REFUSE_ID => 'danger',
                    AdStatus::PENDING_MODERATION_STATUS_ID => 'info',
                    AdStatus::ARCHIVED_ID => 'warning',
                    null => 'danger',
                ])
                ->labels(AdStatus::TOOLTIPS),
            DateTime::make('Modifiée après publication', 'pending_update_since')
                ->help('Annonce en ligne modifiée par son auteur·e et en attente de relecture.')
                ->readonly()
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
