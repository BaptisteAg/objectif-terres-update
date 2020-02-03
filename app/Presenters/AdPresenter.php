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
            return 'landSeek';
        }
        if($this->wrappedObject->landOfferAd) {
            return 'landOffer';
        }
        if($this->wrappedObject->jobAd) {
            return 'jobAd';
        }

        return '';
    }

    public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}
}