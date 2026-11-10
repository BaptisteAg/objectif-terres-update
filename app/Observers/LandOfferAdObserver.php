<?php

namespace App\Observers;

use App\Models\LandOfferAd;
use App\Observers\Traits\ObserverRelationsTrait;

class LandOfferAdObserver
{
    use ObserverRelationsTrait;

    private $fieldList = [
        'sau description' => 'description du foncier agricole',
        'water access' => 'accès à l\'eau',
        'water access description' => 'description accès à l\'eau',
        'has buildings' => 'présence de bâtiment(s) agricole(s)',
        'has houses' => 'présence d\'habitation(s)',
        'price' => 'prix',
        'rent price' => 'loyer',
        'test description' => 'modalité du test agricole',
        'production type add' => 'autre type de production',
        'is beneficiary' => 'utilisateur est le bénéficaire',
    ];

    private $valueList = [
        0 => 'oui',
        1 => 'non',
    ];

    private $fieldToNotTrack = [
        'ad id',
        'id',
        'house id',
        'building id',

    ];

    /**
     * Handle the land offer ad "created" event.
     *
     * @return void
     */
    public function created(LandOfferAd $landOfferAd)
    {
        $this->createdObserverSubAd($landOfferAd, $this->fieldToNotTrack);
    }

    /**
     * Handle the land offer ad "updated" event.
     *
     * @return void
     */
    public function updated(LandOfferAd $landOfferAd)
    {
        $this->updatedObserverSubAd($landOfferAd);
    }

    public function morphToManyAttaching(string $relation, LandOfferAd $landOfferAd, array $ids, array $attributes)
    {
        $this->morphToManySubAdObserver($relation, $landOfferAd, $ids);
    }

    /**
     * Handle the land offer ad "deleted" event.
     *
     * @return void
     */
    public function deleted(LandOfferAd $landOfferAd)
    {
        //
    }

    /**
     * Handle the land offer ad "restored" event.
     *
     * @return void
     */
    public function restored(LandOfferAd $landOfferAd)
    {
        //
    }

    /**
     * Handle the land offer ad "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(LandOfferAd $landOfferAd)
    {
        //
    }
}
