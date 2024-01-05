<?php

namespace App\Nova;

use App\Models\AdStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AttributionAd extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\AttributionAd';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'ad.title';

    public static $with = ['ad'];

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'ad.title',
        'userModerator',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('ID', 'ad.id')->sortable()->readonly(),
            BelongsTo::make('Annonce', 'ad', Ad::class)->readonly(),
            BelongsTo::make('Modérateur', 'userModerator', UserModerator::class),
            Badge::make('Statut', 'ad_status_id')
                ->map([
                    AdStatus::APPROVE_ID => "success",
                    AdStatus::PENDING_ID => "info",
                    AdStatus::REFUSE_ID => "danger",
                    AdStatus::PENDING_MODERATION_STATUS_ID => "info",
                    AdStatus::ARCHIVED_ID => "warning",
                ])
                ->labels(AdStatus::TOOLTIPS),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
