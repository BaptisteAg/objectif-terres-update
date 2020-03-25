<?php
namespace App\Http\Controllers\HelpAreas;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;


class HelpAreasModeratorController extends Controller
{
	protected $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function index()
	{
		if (auth()->user()->role < 2 ) {
			abort(404);
		}

		$users = json_encode($this->userService->findAllExceptPP()) ;
		return view('pages.moderator.help', compact('users'));
	}
}