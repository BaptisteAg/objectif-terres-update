<?php

namespace App\Observers;

use App\Models\LandOfferAd;
use App\Observers\Traits\TracksHistoryTrait;

class LandOfferAdObserver
{
	use TracksHistoryTrait;

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
		0 => "oui",
		1 => "non"
	];

	private $fieldToNotTrack = [
		'ad id',
		'id'
	];

	/**
	 * Handle the land offer ad "created" event.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @return void
	 */
    public function created(LandOfferAd $landOfferAd)
    {
		$this->track($landOfferAd, function ($value, $field) use ($landOfferAd) {
			if (!in_array($field, $this->fieldToNotTrack)) {
				$fieldName = $this->fieldList[$field] ?? $field;
				$valueName = $this->valueList[$value] ?? $value;

				return [
					'ad_id' => $landOfferAd->ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
				];
			}

		});
    }

	/**
	 * Handle the land offer ad "updated" event.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @return void
	 */
    public function updated(LandOfferAd $landOfferAd)
    {
		$this->track($landOfferAd, function ($value, $field) use ($landOfferAd) {
			$fieldName = $this->fieldList[$field] ?? $field;
			$valueName = $this->valueList[$value] ?? $value;

			return [
				'ad_id' => $landOfferAd->ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $valueName . "</em>",
			];
		});
    }

	/**
	 * Handle the land offer ad "deleted" event.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @return void
	 */
    public function deleted(LandOfferAd $landOfferAd)
    {
        //
    }

	/**
	 * Handle the land offer ad "restored" event.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @return void
	 */
    public function restored(LandOfferAd $landOfferAd)
    {
        //
    }

	/**
	 * Handle the land offer ad "force deleted" event.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @return void
	 */
    public function forceDeleted(LandOfferAd $landOfferAd)
    {
        //
    }
}
