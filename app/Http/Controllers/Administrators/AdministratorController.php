<?php

namespace App\Http\Controllers\Administrators;

use App\Http\Controllers\Controller;
use App\Models\Territory;
use App\Services\Users\UserService;

class AdministratorController extends Controller
{
    protected $userService;

    /**
     * AdministratorController constructor.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUsersByTerritories()
    {
        $allTerritoriesId = Territory::all()->pluck('id')->toArray();
        $usersGroupedByTerritories = $this->userService->groupAllUsersByTerritory(0, $allTerritoriesId);

        return view('pages.administrators.show-users-in-territories', compact('usersGroupedByTerritories'));
    }
}
