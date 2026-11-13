<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Mostafaznv\NovaCkEditor\CkEditor;

class CmsPage extends Resource
{
    /**
     * @return string
     */
    public static function label()
    {
        return 'Pages éditables';
    }

    /**
     * @return string
     */
    public static function singularLabel()
    {
        return 'section d\'une page';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CmsPage::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'page_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'page_name', 'description', 'content', 'slug',
    ];

    /**
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom de la page', 'page_name')->sortable()->readonly(true),
            Text::make('Slug', 'slug')->sortable()->readonly(true),
            Text::make('Description', 'description')->readonly(true),
            MorphToMany::make('Documents', 'documents', \App\Nova\Document::class)->canSee(function ($request) {
                return isset($this->has_documents) && $this->has_documents === 1;
            }),
            CkEditor::make('Content')->canSee(function ($request) {
                return isset($this->has_documents) && $this->has_documents === 0;
            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
