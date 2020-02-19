<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;


class HomePageModeratorController extends Controller
{

	public function index()
	{
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();

		return view('pages.moderator.index', compact( 'cities', 'departments', 'regions'));

	}
}