<?php

namespace App\Nova;

use App\Nova\Actions\ReallocateModeratorAds;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserModerator extends User
{
    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Gestion des modérateurs';
    }

    public static function singularLabel()
    {
        return 'Modérateur';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return parent::indexQuery($request, $query)->whereIn('role', [1, 3, 4]);
    }

    public function actions(Request $request)
    {
        return [
            app(ReallocateModeratorAds::class)
                ->forUser($this->resource),
        ];
    }
}
