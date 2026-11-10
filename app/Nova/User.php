<?php

namespace App\Nova;

use App\Nova\Actions\ReallocateModeratorAds;
use App\Nova\Filters\LikelyBotFilter;
use App\Nova\Filters\UserRoleFilter;
use App\Rules\SalesforceUniqueEmail;
use Illuminate\Http\Request;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /** @var \App\Models\User|null */
    public $resource;

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

    public function title()
    {
        return $this->name.' '.$this->first_name.' ('.$this->email.')';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email', 'first_name', 'city',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['cities', 'regions', 'departments', 'zipCode'];

    public function __construct($resource)
    {
        parent::__construct($resource);
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

            Impersonate::make($this),

            Number::make('Score Bot Min', function () {
                return $this->min_recaptcha_score;
            })
                ->help('Score reCAPTCHA minimum (0.0 = bot, 1.0 = humain)')
                ->displayUsing(function ($value) {
                    if ($value === null) {
                        return '-';
                    }
                    if ($value < 0.3) {
                        return '<span style="color: red; font-weight: bold;">'.$value.'</span>';
                    }
                    if ($value < 0.5) {
                        return '<span style="color: orange;">'.$value.'</span>';
                    }

                    return '<span style="color: green;">'.$value.'</span>';
                })->asHtml(),

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

            HasMany::make('Modération', 'adsModerator', AttributionAd::class)
                ->canSee(function ($request) {
                    return isset($this->role) && $this->role >= 1;
                })
                ->hideFromIndex(),

            MorphMany::make('Départements', 'departments', 'App\Nova\Department')->canSee(function ($request) {
                return isset($this->role) && $this->role >= 1;
            }),

            HasMany::make('Permissions spéciales', 'userPermissions', 'App\Nova\UserPermission')->canSee(function ($request) {
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
     * @return array
     */
    public function cards(Request $request)
    {
        return [new Metrics\UsersPerDay, new Metrics\NewUsers];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new UserRoleFilter,
            new LikelyBotFilter,
        ];
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
        return [
            app(ReallocateModeratorAds::class)
                ->canSee(function (Request $request) {
                    if ($request->resourceId) {
                        $user = \App\Models\User::find($request->resourceId);

                        return $user->role > 0;
                    }

                    return $request->has('new_moderator_id') || $this->resource->role > 0;
                })
                ->forUser($this->resource),
        ];
    }
}
