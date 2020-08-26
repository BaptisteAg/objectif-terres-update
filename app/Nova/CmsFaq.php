<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class CmsFaq extends Resource
{
	/**
	 * @return string
	 */
	public static function label()
	{
		return 'Gestion Faq';
	}

	/**
	 * @return string
	 */
	public static function singularLabel()
	{
		return 'élément de la faq';
	}

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Models\\CmsFaq';

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
		'id', 'page_name', 'content_question', 'content_answer',
    ];

	/**
	 * @param Request $request
	 * @return bool
	 */
	public static function authorizedToCreate(Request $request)
	{
		return false;
	}

	/**
	 * @param Request $request
	 * @return bool
	 */
	public function authorizedToDelete(Request $request)
	{
		return false;
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
			Text::make('Visible sur la page', 'page_name')->sortable()->readonly(true),
			Text::make('Question', 'content_question')->readonly(true),
			CKEditor5Classic::make('Content', 'content_answer')->withMeta(['maxlength' => 5]),
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
