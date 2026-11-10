<?php

namespace App\Nova;

use App\Models\AdStatus;
use App\Nova\Filters\DepartmentFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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
    public static $model = \App\Models\Ad::class;

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
        return $this->id.' - '.$this->title.' ('.$this->resource->userPp?->name.' '.$this->resource->userPp?->first_name.')';
    }

    public static $with = ['attributionAd', 'userPp', 'userModerator'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'ads.id',
        'title',
        'userPp.id',
        'userPp.name',
        'userPp.first_name',
        'userPp.email',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query
            ->withTrashed()
            ->select('*', 'ads.id as id')
            ->join('users as userPp', 'userPp.id', '=', 'ads.user_pp_id');

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Titre'), 'title')->resolveUsing(fn ($title) => Str::words($title, 10)),
            BelongsTo::make('Départment', 'department', Department::class)
                ->searchable()
                ->sortable(),
            BelongsTo::make('Annonceur', 'userPp', User::class)
                ->searchable()
                ->sortable()
                ->readonly(),
            Badge::make('Statut', 'attributionAd.ad_status_id')
                ->map([
                    '' => 'danger',
                    AdStatus::APPROVE_ID => 'success',
                    AdStatus::PENDING_ID => 'info',
                    AdStatus::REFUSE_ID => 'danger',
                    AdStatus::PENDING_MODERATION_STATUS_ID => 'info',
                    AdStatus::ARCHIVED_ID => 'warning',
                ])
                ->labels(array_map(fn ($tooltip) => Str::words($tooltip, 5), AdStatus::TOOLTIPS)),

            HasOne::make('Modération', 'attributionAd', AttributionAd::class)
                ->hideFromIndex(),

            // Survey fields
            Badge::make('Supprimée', 'deleted_at')
                ->map([
                    null => 'success',
                    '*' => 'danger',
                ])
                ->labels([
                    null => 'Non',
                    '*' => 'Oui',
                ])
                ->resolveUsing(fn ($value) => $value ? 'deleted' : null)
                ->hideFromDetail(),

            Select::make('Succès via OT', 'survey_success_via_platform')
                ->options([
                    'oui' => 'Oui',
                    'non' => 'Non',
                ])
                ->displayUsingLabels()
                ->nullable(),

            Textarea::make('Remarques enquête', 'survey_comments')
                ->hideFromIndex()
                ->nullable(),

            DateTime::make('Date enquête', 'survey_submitted_at')
                ->hideFromIndex()
                ->nullable(),

            DateTime::make('Date suppression', 'deleted_at')
                ->hideFromIndex()
                ->nullable(),
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
        return [new DepartmentFilter];
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

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }
}
