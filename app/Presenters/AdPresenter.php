<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\City;
use App\Models\Document;
use App\Models\Region;
use App\Models\User;
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

	public function isSupportRequest(): bool
    {
        return !!$this->wrappedObject->project;
    }

    public function pp_display_name(): string
    {
        $user = $this->wrappedObject->userPp;

        if(!$user->first_name || !$user->name) {
            return $user->email;
        }

        return $user->first_name. " ". $user->name;
    }

	public function ad_type_full_name(): string
    {
        return match($this->wrappedObject->type) {
            'landSeekAd' => 'Recherche de foncier',
            'landOfferAd' => 'Offre de foncier',
            'jobOfferAd' => 'Offre opportunité professionnelle',
            'jobSeekAd' => 'Recherche opportunité professionnelle',
            default => '',
        };
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

		return \Carbon\Carbon::parse($this->wrappedObject->created_at)->diffForHumans();
	}

	public function published_on_diff()
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

	public function shortLocationsList()
    {
        $locations = array_filter([
            $this->shortLocationsListByType('cities'),
            $this->shortLocationsListByType('departments'),
            $this->shortLocationsListByType('regions'),
        ]);

        $concatenatedLocations = implode(', ',$locations);

        if(count($locations) > 1 && substr_count($concatenatedLocations, '.') > 3) {
            return reset($locations);
        }

        return $concatenatedLocations;
    }

	public function shortLocationsListByType($type)
	{

		$locations = null;
		if ($this->wrappedObject->$type->count() >= 3) {
			$i = 0;
			$len = 3;
			foreach ($this->wrappedObject->$type->take(3) as $key => $attribute) {
				if ($key === 0) {
					$locations = $locations . $attribute['name'];
				} elseif ($i == $len - 1) {
					$locations = $locations . ', ' . $attribute['name'] . '...';
				} else {
					$locations = $locations . ', ' . $attribute['name'];
				}
				$i++;
			}
			return $locations;
		}
		return call_user_func([$this, $type.'List']);
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
			return /*$this->isPpDocument($document) &&*/ $this->isImageDocument($document);
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
		return $this->wrappedObject->project !== null;
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

				if($min === 0 && $max === 0) {
				    return "";
                }

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
			if ($ad->landOfferAd->surface) {
				return $ad->landOfferAd->surface . " ha";
			} else {
				return "Surface non renseignée";
			}
		}

		return '';
	}

	private function isPpDocument(Document $document)
	{
		return $document->user_id === $this->wrappedObject->user_pp_id;
	}

	public function isProjectAttributedToAdvisor()
	{
		$ad = $this->wrappedObject;
        $advisorIds = array_map(function($advisor) { return $advisor->id; }, $ad->attributionAd->getAdvisors());

		return in_array(auth()->user()->id, $advisorIds);
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

    public function surface(): ?string
    {
        $ad = $this->wrappedObject;

        $surface = null;

        if ($ad->type === 'landOfferAd') {
            $surface = $ad->landOfferAd->surface;
        } elseif ($ad->type === 'landSeekAd') {
            $min = $ad->landSeekAd->surface_range_min;
            $max = $ad->landSeekAd->surface_range_max;

            if ($min === $max) {
                $surface = $min;
            } else if ($max === 1000000) {
                if ($min === 0) {
                    $surface = "∞";
                } else {
                    $surface = 'Au moins ' . $min;
                }
            } else if ($min === 0) {
                $surface = 'Jusqu\'à ' . $max;
            } else {
                $surface = $min . ' - ' . $max;
            }
        }
        return $surface;
    }

    public function formatted_type(): string
    {
        $ad = $this->wrappedObject;
        $type = match ($ad->type) {
            "landOfferAd" => "Vente",
            "landSeekAd" => "Recherche",
            "jobSeekAd" => "Recherche Emploi",
            "jobOfferAd" => "Offre Emploi",
        };
        if ($ad->type === 'landOfferAd') {
            $type = $ad->landOfferAd->offerGenres->pluck('name')->join(', ');
        }

        return $type;
    }
    public function formatted_location() : string
    {
        $ad = $this->wrappedObject;
        $region = null;
        $department = $this->wrappedObject->department;
        $region = $department?->region;

        if(!$department) {
            if ($ad->regions->count()) {
                $region = $ad->regions->first();
            }

            if ($ad->departments->count()) {
                $department = $ad->departments->first();
                if (!$region) {
                    $region = $department?->region?->first();
                }
            } elseif ($ad->cities->count()) {
                $department = $ad->cities->first()?->department?->first();
                if (!$region) {
                    $region = $department?->region?->first();
                }
            }
            else if($region && !$department) {
                $department = $region->departments->first();
            }
        }

        return $department?->name . ' (' . $department?->code . ') • '. $region?->name;
    }

    public function formatted_price() : string
    {
        $ad = $this->wrappedObject;
        //$price =  'Prix non renseigné';
        $price =  '';

        if($ad->landOfferAd) {
            if($ad->landOfferAd->price || $ad->landOfferAd->rent_price) {
                $price = '';

                if($ad->landOfferAd->price) {
                    $price .= number_format($ad->landOfferAd->price, 0, ",", " " ).' €';
                }
                if($ad->landOfferAd->price && $ad->landOfferAd->rent_price) {
                    $price .= ' ou ';
                }
                if($ad->landOfferAd->rent_price) {
                    $price .= number_format($ad->landOfferAd->rent_price, 0, ",", " " ).' € / an';
                }
            }
        }

        return $price;
    }
}
