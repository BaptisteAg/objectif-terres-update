<?php

namespace App\Observers;

use App\Models\Ad;
use App\Observers\Traits\TracksHistoryTrait;

class AdObserver
{
	use TracksHistoryTrait;

	private $fieldList = [
		'is draft' => ' mode brouillon',
		'title' => 'titre',
		'about content' => 'à propos',
		'about project content' => 'à propos du projet',
		'accept share contact infos' => 'accepte de recevoir des informations',
		'is partner' => 'annonceur certifié',
	];

	private $valueList = [
		0 => "oui",
		1 => "non"
	];

	private $fieldToNotTrack = [
		'user pp id',
		'id'
	];

	/**
	 * Handle the ad "created" event.
	 *
	 * @param Ad $ad
	 * @return void
	 */
	public function created(Ad $ad)
	{
		$this->track($ad, function ($value, $field) use ($ad) {
			if (in_array($field, $this->fieldToNotTrack)) {
				return $field = null;
			}
				$fieldName = $this->fieldList[$field] ?? $field;
				$valueName = $this->valueList[$value] ?? $value;
				return [
					'ad_id' => $ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
				];


		});
	}

	/**
	 * Handle the ad "updated" event.
	 *
	 * @param Ad $ad
	 * @return void
	 */
	public function updated(Ad $ad)
	{
		$this->track($ad, function ($value, $field) use ($ad) {
			$fieldName = $this->fieldList[$field] ?? $field;
			$valueName = $this->valueList[$value] ?? $value;

			return [
				'ad_id' => $ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $valueName . "</em>",
			];
		});
	}

	/**
	 * Handle the ad "deleted" event.
	 *
	 * @param Ad $ad
	 * @return void
	 */
	public function deleted(Ad $ad)
	{
		$this->track($ad, function ($value, $field) use ($ad) {
			return [
				'ad_id' => $ad->id,
				'body' => "Suppression de l'annonce" . $ad->id . ".",
			];
		});
	}

	/**
	 * Handle the ad "restored" event.
	 *
	 * @param Ad $ad
	 * @return void
	 */
	public function restored(Ad $ad)
	{
		//
	}

	/**
	 * Handle the ad "force deleted" event.
	 *
	 * @param Ad $ad
	 * @return void
	 */
	public function forceDeleted(Ad $ad)
	{
		//
	}
}
