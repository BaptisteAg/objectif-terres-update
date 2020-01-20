<?php namespace App\Presenters;

use App\Models\Ad;
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
            return 'land_seek';
        }
        if($this->wrappedObject->landOfferAd) {
            return 'land_offer';
        }
        if($this->wrappedObject->jobAd) {
            return 'job_ad';
        }

        return '';
    }
}