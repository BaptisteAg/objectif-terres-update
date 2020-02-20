<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;


class HomePageModeratorController extends Controller
{

	public function index()
	{
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		return view('pages.moderator.index', compact( 'cities', 'departments', 'regions','projectStatuses', 'adStatuses', 'productionGenres','jobOfferTypes'));

	}
}