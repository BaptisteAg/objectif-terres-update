<?php

namespace App\Nova;

use App\Models\AdStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @property \App\Models\Ad $resource
 */
class Ad extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Ad';

    public static function label()
    {
        return 'Annonces';
    }

    public static function singularLabel()
    {
        return 'Annonce';
    }

    public function title()
    {
        return $this->resource->id." - ".$this->title . ' (' . $this->resource->userPp?->name . ' ' . $this->resource->userPp?->first_name .  ')';
    }

    public static $with = ['attributionAd', 'userPp'];


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'userPp.name',
        'userPp.first_name',
        'userPp.email',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->join('users as userPp', 'userPp.id', '=', 'ads.user_pp_id');
        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Titre'), 'title')->resolveUsing(fn($title) => Str::words($title, 10)),
            BelongsTo::make('Annonceur', 'userPp', User::class),
            Badge::make('Statut', 'attributionAd.ad_status_id')
                ->map([
                    '' => 'danger',
                    AdStatus::APPROVE_ID => "success",
                    AdStatus::PENDING_ID => "info",
                    AdStatus::REFUSE_ID => "danger",
                    AdStatus::PENDING_MODERATION_STATUS_ID => "info",
                    AdStatus::ARCHIVED_ID => "warning",
                ])
                ->labels(array_map(fn($tooltip) => Str::words($tooltip, 5), AdStatus::TOOLTIPS)),
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
