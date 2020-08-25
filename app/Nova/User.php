<?php

namespace App\Nova;

use App\Rules\SalesforceUniqueEmail;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class User extends Resource
{

	public static function label()
	{
		return 'Gestion des utilisateurs';
	}

	public static function singularLabel()
	{
		return 'Utilisateur';
	}

	/**
	 * The model the resource corresponds to.
	 *
	 * @var string
	 */
	public static $model = 'App\\Models\\User';

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
		'id', 'name', 'email', 'first_name', 'city'
	];


	/**
	 * The relationships that should be eager loaded on index queries.
	 *
	 * @var array
	 */
	public static $with = ['cities', 'regions', 'departments', 'zipCode'];

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

//			Gravatar::make(),

			Text::make('Civilité', 'civility', function () {
				if (isset($this->civility)) {
					return \App\Models\User::$civilities[$this->civility];
				}
			})->exceptOnForms()->onlyOnDetail(),


			Select::make('Civilité', 'civility')->options(function () {
				$arrayValues = [];
				foreach (\App\Models\User::$civilities as $key => $value) {
					$arrayValues[$key] = $value;
				}
				return $arrayValues;
			})->onlyOnForms(),

			Text::make('Nom', 'name')
				->sortable()
				->rules('required', 'max:255'),

			Text::make('Prénom', 'first_name')
				->sortable()
				->rules('required', 'string', 'max:255'),

			Text::make('Email')
				->sortable()
				->rules('required', 'email', 'max:255', app(SalesforceUniqueEmail::class))
				->creationRules('unique:users,email')
				->updateRules('unique:users,email,{{resourceId}}', app(SalesforceUniqueEmail::class)),

			Text::make('Téléphone', 'phone')
				->rules('nullable', 'string', 'max:30')->hideFromIndex(),

			Text::make('Adresse', 'street')
				->rules('required', 'string', 'max:255')->hideFromIndex(),

			BelongsTo::make('Ville', 'zipCode', City::class)->searchable(),

			Text::make('Role', function () {
				if (isset($this->role)) {
					return \App\Models\User::$roles[$this->role];
				}
			})->exceptOnForms()
				->sortable(),

			Select::make('Role')
				->options([0 => \App\Models\User::$roles[0]])
				->rules('required')
				->onlyOnForms()
				->hideWhenUpdating(),

			Text::make('Profile', function () {
				if (isset($this->profile)) {
					return \App\Models\User::$profiles[$this->profile];
				}
			})->exceptOnForms()->onlyOnDetail(),

			Select::make('Profile', 'profile')->options(function () {
				$arrayValues = [];
				foreach (\App\Models\User::$profiles as $key => $value) {
					$arrayValues[$key] = $value;
				}
				return $arrayValues;
			})->onlyOnForms(),

			MorphMany::make('Territoires', 'departments', 'App\Nova\Department')->canSee(function($request){
				return isset($this->role) && $this->role >= 1;
			}),

			HasMany::make('Permission de l\'utilisateur', 'userPermissions', 'App\Nova\UserPermission')->canSee(function ($request) {
				return isset($this->role) && $this->role >= 1;
			}),

			Password::make('Mot de passe', 'Password')
				->onlyOnForms()
				->creationRules('required', 'string', 'min:8')
				->updateRules('nullable', 'string', 'min:8'),
		];
	}


	/**
	 * Get the cards available for the request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function cards(Request $request)
	{
		return [new Metrics\UsersPerDay, new Metrics\NewUsers];
	}

	/**
	 * Get the filters available for the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function filters(Request $request)
	{
		return [];
	}

	/**
	 * Get the lenses available for the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function lenses(Request $request)
	{
		return [];
	}

	/**
	 * Get the actions available for the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function actions(Request $request)
	{
		return [];
	}
}
