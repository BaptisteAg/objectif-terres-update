<?php

namespace App\Observers;

use App\Models\LandSeekAd;
use App\Observers\Traits\TracksHistoryTrait;

class LandSeekAdObserver
{
	use TracksHistoryTrait;

	private $fieldList = [
		'is bio' => 'projet biologique',
		'land description' => 'description du terrain',
		'production type add' => 'autre type de production',
		'experience farming' => 'expériences agricoles',
		'surface range min' => 'surface minimum recherchée',
		'surface range max' => 'surface maximum recherchée',
		'rent max' => 'loyer',
		'price max' => 'prix',
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
	 * Handle the land seek ad "created" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function created(LandSeekAd $landSeekAd)
	{
		$this->track($landSeekAd, function ($value, $field) use ($landSeekAd) {
			if (!in_array($field, $this->fieldToNotTrack)) {
				$fieldName = $this->fieldList[$field] ?? $field;
				$valueName = $this->valueList[$value] ?? $value;

				return [
					'ad_id' => $landSeekAd->ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
				];
			}
		});
	}

	/**
	 * Handle the land seek ad "updated" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function updated(LandSeekAd $landSeekAd)
	{
		$this->track($landSeekAd, function ($value, $field) use ($landSeekAd) {
			$fieldName = $this->fieldList[$field] ?? $field;
			$valueName = $this->valueList[$value] ?? $value;

			return [
				'ad_id' => $landSeekAd->ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $valueName . "</em>",
			];
		});
	}

	/**
	 * Handle the land seek ad "deleted" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function deleted(LandSeekAd $landSeekAd)
	{
		//
	}

	/**
	 * Handle the land seek ad "restored" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function restored(LandSeekAd $landSeekAd)
	{
		//
	}

	/**
	 * Handle the land seek ad "force deleted" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function forceDeleted(LandSeekAd $landSeekAd)
	{
		//
	}
}
