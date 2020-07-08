<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\City;
use App\Models\Document;
use App\Models\Region;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class AdPresenter
 * @package App\Presenters
 * @property Ad $wrappedObject
 */
class AdPresenter extends BasePresenter
{
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
			return 'Offre d\'emploi';
		}
		if ($this->wrappedObject->jobSeekAd) {
			return 'Recherche d\'emploi';
		}

		return '';
	}

	public function created_at()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

	public function submitDate()
	{
        if(!$this->wrappedObject->attributionAd) {
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
	    if(!$this->wrappedObject->attributionAd) {
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
        if(!$this->wrappedObject->attributionAd) {
            return '';
        }

		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->published_on)->format('d/m/Y');
	}

	public function waterAccess()
	{
		$waterAccess = null;
		if ($this->wrappedObject->landOfferAd) {
			if (isset($this->wrappedObject->landOfferAd->water_access)) {
				if ($this->wrappedObject->landOfferAd->water_access == true) {
					$waterAccess = "Oui";
				} else {
					$waterAccess = "Non";
				}
			} else {
				$waterAccess = "Ne sais pas";
			}
		}
		return $waterAccess;
	}

	public function human_ha()
    {
        $ad = $this->wrappedObject;

        if($ad->landSeekAd) {
            if($ad->landSeekAd->surface_range_max) {
                $max = $ad->landSeekAd->surface_range_max;
                $min = $ad->landSeekAd->surface_range_min;

                if($max === 100000 && $min === 0) {
                    return "De 1 à > 100ha";
                }

                if($min) {
                    return "De ".$min. "ha à ".$max."ha";
                }

                return "A partir de ".$max."ha";
            }
            else {
                return "Surface non renseignéee";
            }
        }
        else if($ad->landOfferAd) {
            if(isset($ad->landOfferAd->surface)) {
                return $ad->landOfferAd->surface." ha";
            }
            else {
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

}