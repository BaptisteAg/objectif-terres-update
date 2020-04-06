<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\City;
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
		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->created_at)->format('d/m/Y');
	}

	public function is_today()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->created_at)->isToday();
	}

	public function created_at_diff()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->published_on)->diffForHumans();
	}

	public function updated_at()
	{
		return \Carbon\Carbon::parse($this->wrappedObject->updated_at)->format('d/m/Y');
	}


	public function locationable_radius()
	{
		return $this->wrappedObject->cities[0]->pivot->radius;
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
			return $this->documentIsImage($document);
		});
	}

	public function nonImageDocuments()
	{
		return $this->wrappedObject->documents->filter(function ($document) {
			return !$this->documentIsImage($document);
		});
	}

	private function documentIsImage($document)
	{
		return strpos($document->type, 'image') !== false;
	}

	public function published_on()
	{
		if (is_null($this->wrappedObject->attributionAd->published_on)) {
			return $this->wrappedObject->attributionAd->published_on;
		} else {
			return \Carbon\Carbon::parse($this->wrappedObject->attributionAd->published_on)->format('d/m/Y');
		}

	}

}