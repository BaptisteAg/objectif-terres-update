<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\City;
use App\Models\Document;
use App\Models\Region;
use App\Services\Ads\AdService;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class AdPresenter
 * @package App\Presenters
 * @property Ad $wrappedObject
 */
class AdPresenter extends BasePresenter
{
	/**
	 * @var AdService
	 */
	protected $adService;

	/**
	 * AdPresenter constructor.
	 * @param AdService $adService
	 */
	public function __construct(AdService $adService)
	{
		$this->adService = $adService;
	}

	public function ad_type()
	{
		if ($this->wrappedObject->landSeekAd) {
			return 'landSeek';
		}
		if ($this->wrappedObject->landOfferAd) {
			return 'landOffer';
		}
		if ($this->wrappedObject->jobOfferAd) {
			return 'jobOffer';
		}
		if ($this->wrappedObject->jobSeekAd) {
			return 'jobSeek';
		}

		return '';
	}

	public function ad_type_full_name()
	{
		if ($this->wrappedObject->landSeekAd) {
			return 'Recherche de foncier';
		}
		if ($this->wrappedObject->landOfferAd) {
			return 'Offre de foncier';
		}
		if ($this->wrappedObject->jobOfferAd) {
			return 'Offre opportunité professionnelle';
		}
		if ($this->wrappedObject->jobSeekAd) {
			return 'Recherche opportunité professionnelle';
		}

		return '';
	}

	public function created_at()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

	public function submitDate()
	{
		if (!$this->wrappedObject->attributionAd) {
			return '';
		}

		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->created_at)->format('d/m/Y');
	}

	public function is_today()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->created_at)->isToday();
	}

	public function created_at_diff()
	{
		if (!$this->wrappedObject->attributionAd) {
			return '';
		}

		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->published_on)->diffForHumans();
	}

	public function updated_at()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->updated_at)->format('d/m/Y');
	}


	public function locationable_radius()
	{
		$locationRadius = null;
		if (!empty($this->wrappedObject->cities[0]->pivot->radius)) {
			$locationRadius = $this->wrappedObject->cities[0]->pivot->radius;
		}
		return $locationRadius;
	}

	public function regionsList()
	{
		$regions = null;
		foreach ($this->wrappedObject->regions as $key => $attribute) {
			if ($key === 0) {
				$regions = $regions . $attribute['name'];
			} else {
				$regions = $regions . ', ' . $attribute['name'];
			}
		}
		return $regions;
	}

	public function departmentsList()
	{
		$departments = null;

		foreach ($this->wrappedObject->departments as $key => $attribute) {
			if ($key === 0) {
				$departments = $departments . $attribute['name'];
			} else {
				$departments = $departments . ', ' . $attribute['name'];
			}
		}
		return $departments;
	}

	public function citiesList()
	{

		$cities = null;
		foreach ($this->wrappedObject->cities as $key => $attribute) {
			if ($key === 0) {
				$cities = $cities . $attribute['name'];
			} else {
				$cities = $cities . ', ' . $attribute['name'];
			}
		}
		return $cities;
	}

	public function shortCitiesList()
	{

		$cities = null;
		if ($this->wrappedObject->cities->count() >= 3) {
			$i = 0;
			$len = 3;
			foreach ($this->wrappedObject->cities->take(3) as $key => $attribute) {
				if ($key === 0) {
					$cities = $cities . $attribute['name'];
				} elseif ($i == $len - 1) {
					$cities = $cities . ', ' . $attribute['name'] . '...';
				} else {
					$cities = $cities . ', ' . $attribute['name'];
				}
				$i++;
			}
			return $cities;
		}
		return $this->citiesList();
	}

	public function zipCodesByCity()
	{
		return $this->wrappedObject->cities->mapToGroups(function (City $city, $key) {
			return [$city['name'] => $city["zip_code"]];
		});
	}

	public function hasImages()
	{
		return $this->images()->count();
	}

	public function hasNonImageDocuments()
	{
		return $this->nonImageDocuments()->count();
	}

	public function images()
	{
		return $this->wrappedObject->documents->filter(function ($document) {
			return $this->isPpDocument($document) && $this->isImageDocument($document);
		})->values();
	}

	public function nonImageDocuments()
	{
		return $this->wrappedObject->documents->filter(function ($document) {
			return $this->isPpDocument($document) && !$this->isImageDocument($document);
		})->values();
	}

	public function documentsUploadedByUser()
	{
		return $this->wrappedObject->documents->filter(function ($document) {
			return $this->isPpDocument($document);
		})->values();
	}

	public function documentsUploadedByAdvisors()
	{
		return $this->wrappedObject->documents->filter(function ($document) {
			return $document->user_id !== $this->wrappedObject->user_pp_id;
		})->values();
	}

	private function isImageDocument($document)
	{
		return strpos($document->type, 'image') !== false;
	}

	public function published_on()
	{
		if (!$this->wrappedObject->attributionAd) {
			return '';
		}

		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->published_on)->format('d/m/Y');
	}

	public function isProject()
	{
		return $this->wrappedObject->project()->exists();
	}

	public function refused_on()
	{
		if (!$this->wrappedObject->attributionAd) {
			return '';
		}

		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->refused_on)->format('d/m/Y');
	}

	public function waterAccess()
	{
		$waterAccess = null;
		if ($this->wrappedObject->landOfferAd) {
			if (isset($this->wrappedObject->landOfferAd->water_access)) {
				if ($this->wrappedObject->landOfferAd->water_access == 1) {
					if (!is_null($this->wrappedObject->landOfferAd->water_access_description)) {
						$waterAccess = $this->wrappedObject->landOfferAd->water_access_description;
					} else {
						$waterAccess = "Oui";
					}
				} elseif ($this->wrappedObject->landOfferAd->water_access == -1) {
					$waterAccess = "Je ne sais pas";
				} else {
					$waterAccess = "Non";
				}
			}

		}
		return $waterAccess;
	}

	public function human_ha()
	{
		$ad = $this->wrappedObject;

		if ($ad->landSeekAd) {
			if ($ad->landSeekAd->surface_range_max) {
				$max = $ad->landSeekAd->surface_range_max;
				$min = $ad->landSeekAd->surface_range_min;

				if ($max === 1000000 && $min === 0) {
					return "De 1 à + de 100ha";
				}
				if ($max === 1000000) {
					$max = '+ de 100';
				}

				if ($min && $max === 1000000) {
					return "Surface non précisée";
				}
				if ($min) {
					return "De " . $min . "ha à " . $max . "ha";
				}

				return "Moins de " . $max . "ha";
			} else if ($ad->landSeekAd->surface_range_min) {
				$min = $ad->landSeekAd->surface_range_min;
				return "Plus de " . $min . "ha";
			} else {
				return "Surface non renseignée";
			}
		} else if ($ad->landOfferAd) {
			if (isset($ad->landOfferAd->surface)) {
				return $ad->landOfferAd->surface . " ha";
			} else {
				return "Surface non renseignée";
			}
		}

		return '';
	}

	public function canEdit()
	{
		$ad = $this->wrappedObject;

		return $ad->user_pp_id === auth()->id();
	}

	private function isPpDocument(Document $document)
	{
		return $document->user_id === $this->wrappedObject->user_pp_id;
	}

	public function isProjectAttributedToAdvisor()
	{
		$ad = $this->wrappedObject;
		if (!is_null($ad->project_id)) {
			if (!is_null($ad->attributionAd->user_advisor_id)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get all departments codes related to the territories targeted by the ad
	 * @return array
	 */
	public function adDepartmentsCodes(): array
	{
		return $this->adService->getAdDepartmentCodesFromZones($this->wrappedObject);
	}


	/**
	 * @param array $userTerritoriesCodes
	 * @param array $userTerritoryId
	 * @return bool
	 */
	public function isAdInUserTerritories(array $userTerritoriesCodes, array $userTerritoryId): bool
	{
		$ad = $this->wrappedObject;
		if (isset($ad->support_request_territory_id)) {
			return in_array($ad->support_request_territory_id, $userTerritoryId);
		}
		return count(array_intersect($userTerritoriesCodes, $this->adDepartmentsCodes())) > 0;
	}

	/**
	 * @param array $userTerritoryId
	 * @param array $userDepartmentsCode
	 * @return bool
	 */
	public function isProjectInUserTerritories(array $userTerritoryId, array $userDepartmentsCode): bool
	{
		$ad = $this->wrappedObject;
		if (isset($ad->support_request_territory_id)) {
			return in_array($ad->support_request_territory_id, $userTerritoryId);
		}
		//TODO delete this system based on department code when system based on territory fully integrated, don't forget to attributes of all methods calls
		return count(array_intersect($userDepartmentsCode, $this->adDepartmentsCodes())) > 0;
	}


}