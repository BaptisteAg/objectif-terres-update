<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class CmsCommonContent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Models\\CmsCommonContent';

	/**
	 * @return string
	 */
	public static function label()
	{
		return 'Sections communes éditables';
	}

	/**
	 * @return string
	 */
	public static function singularLabel()
	{
		return 'section commune';
	}

	/**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
		'id', 'pages_name', 'description', 'content', 'name'
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
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function fields(Request $request)
	{
		return [
			ID::make()->sortable(),
			Text::make('Nom de la section', 'name')->sortable()->readonly(true),
			Text::make('Description', 'description')->readonly(true),
			Text::make('Présence sur les pages', 'pages_name')->onlyOnDetail()->readonly(true),
			MorphToMany::make('Documents', 'documents', 'App\Nova\Document'),
			CKEditor5Classic::make('Content')->withFiles('public')->canSee(function ($request) {
				return isset($this->has_documents) && $this->has_documents === 0;
			})
				->options([
					"toolbar" => [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'indent',
						'outdent',
						'|',
						'imageUpload',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo'
					],
				]),
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
