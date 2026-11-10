<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class SpamFilter extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\SpamFilter';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'value';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'value',
        'description',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Filtres Anti-Spam';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Filtre Anti-Spam';
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

            Select::make('Type')
                ->options([
                    'email' => 'Email (adresse email a bloquer)',
                    'pattern' => 'Motif (phrase ou mot-cle a bloquer)',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required'),

            Text::make('Valeur', 'value')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Email ou phrase a bloquer dans les messages'),

            Text::make('Description')
                ->sortable()
                ->rules('max:255')
                ->help('Description pour identifier ce filtre (ex: "Arnaque fausse bourse FMI")'),

            Boolean::make('Actif', 'is_active')
                ->sortable()
                ->help('Desactiver pour suspendre temporairement ce filtre'),

            DateTime::make('Cree le', 'created_at')
                ->onlyOnDetail(),

            DateTime::make('Modifie le', 'updated_at')
                ->onlyOnDetail(),
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
