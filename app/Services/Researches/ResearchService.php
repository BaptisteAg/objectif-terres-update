<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\Region;
use App\Repositories\Researches\ResearchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResearchService
{
	/**
	 * @var ResearchRepository
	 */
	protected $repository;

	public function __construct(ResearchRepository $repository)
	{
		$this->repository = $repository;
	}


	public function create(Request $request)
	{
		$adType = $request->input('ad_type');
		$regions = $request->input('regions');
		$name = $request->input('name');


		$data['ad_type'] = $adType;
		$data['regions'] = $regions;
		$data['name'] = $name;

		$research = DB::transaction(function () use ($data) {
			$research = $this->repository->create($data);

			return $research;
		});

		return $research;
	}

	public function find(int $id)
	{
		$research = $this->repository->find($id);

		return $research;
	}

	public function findAll()
	{

		$researches = $this->repository->all();
		return $researches;
	}

	public function index(Request $request)
	{

		$adTypeInput = $request->input('ad_type');
		$adCategory = $request->input('ad_category');
        $idRegions = $request->input('regions_location_researches');
        $idDepartments = $request->input('departments_location_researches');
        $idCities = $request->input('cites_location_researches');
        $radius = $request->input('radius_research');
        $offer_genres = $request->input('offer_genres');
        $surfaces = $request->input('surfaces_research');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $has_pics = $request->input('has_pics');
        $has_building = $request->input('has_buildings');
        $productionGenres = $request->input('production_genres');
        $bioCertifications = $request->input('bio_certifications');


		if ($adCategory === 'land') {
			$adType = ($adTypeInput === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
		} else if ($adCategory === 'offer') {
			$adType = ($adTypeInput === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd';
		} else {
			$adType = $adTypeInput;
		}


		if ($idRegions && !in_array('0', $idRegions)) {
			$regions = Region::with('ads')->whereIn('id', $idRegions)->get();
		} else {
			$regions = Region::all();
		}

		$ads = collect();

		foreach ($regions as $region) {
			$regionAds = $region->ads;
			foreach ($regionAds as $key => $ad) {
				if ($ad->$adType) {
				    dd($ad->$adType->where('building_id', '=', '1'));
					$ads[$ad->id] = $ad;
				}
			}
		}

		return [$ads, $adType, $regions];
	}
	public function destroy (Request $request){
		$researchId = $request->input('research');
		$research = $this->find($researchId);
		$research->delete();
	}
}
