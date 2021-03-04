<?php

namespace App\Observers;

use App\Models\JobOfferAd;
use App\Observers\Traits\TracksHistoryTrait;

class JobOfferAdObserver
{
	use TracksHistoryTrait;

	private $fieldList = [
		'is activity transmission' => ' transmission ou d\'une possibilité de transmission de l\'activité agricole',
		'experience farming' => 'expérience souhaitée dans le milieu agricole',
		'job description' => 'description du poste',
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
	 * Handle the job offer ad "created" event.
	 *
	 * @param JobOfferAd $jobOfferAd
	 * @return void
	 */
	public function created(JobOfferAd $jobOfferAd)
	{

		$this->track($jobOfferAd, function ($value, $field) use ($jobOfferAd) {
			if (!in_array($field, $this->fieldToNotTrack)) {
				$fieldName = $this->fieldList[$field] ?? $field;
				$valueName = $this->valueList[$value] ?? $value;

				return [
					'ad_id' => $jobOfferAd->ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
				];
			}

		});
	}

	/**
	 * Handle the job offer ad "updated" event.
	 *
	 * @param JobOfferAd $jobOfferAd
	 * @return void
	 */
	public function updated(JobOfferAd $jobOfferAd)
	{
		$this->track($jobOfferAd, function ($value, $field) use ($jobOfferAd) {
			$fieldName = $this->fieldList[$field] ?? $field;
			$valueName = $this->valueList[$value] ?? $value;

			return [
				'ad_id' => $jobOfferAd->ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $valueName . "</em>",
			];
		});
	}

	/**
	 * Handle the job offer ad "deleted" event.
	 *
	 * @param JobOfferAd $jobOfferAd
	 * @return void
	 */
	public function deleted(JobOfferAd $jobOfferAd)
	{
		//
	}

	/**
	 * Handle the job offer ad "restored" event.
	 *
	 * @param JobOfferAd $jobOfferAd
	 * @return void
	 */
	public function restored(JobOfferAd $jobOfferAd)
	{
		//
	}

	/**
	 * Handle the job offer ad "force deleted" event.
	 *
	 * @param JobOfferAd $jobOfferAd
	 * @return void
	 */
	public function forceDeleted(JobOfferAd $jobOfferAd)
	{
		//
	}
}
