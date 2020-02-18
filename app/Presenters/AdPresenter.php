<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\City;
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
        if($this->wrappedObject->landSeekAd) {
            return 'landSeek';
        }
        if($this->wrappedObject->landOfferAd) {
            return 'landOffer';
        }
        if($this->wrappedObject->jobOfferAd) {
            return 'jobOffer';
        }
        if($this->wrappedObject->jobSeekAd) {
            return 'jobSeek';
        }

        return '';
    }

    public function created_at()
    {
        return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
    }

    public function is_today()
    {
        return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->isToday();
    }

    public function created_at_diff()
    {
        return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->diffForHumans();
    }


    public function locationable_radius()
    {
        return $this->wrappedObject->cities[0]->pivot->radius;
    }

    public function zipCodesByCity()
    {
        return $this->wrappedObject->cities->mapToGroups(function(City $city, $key) {
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

}