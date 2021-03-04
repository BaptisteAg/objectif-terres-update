<?php

namespace App\Observers;

use App\Models\JobSeekAd;
use App\Observers\Traits\TracksHistoryTrait;

class JobSeekAdObserver
{
	use TracksHistoryTrait;

	private $fieldList = [
		'experience farming' => 'expérience agricole',
	];

	private $fieldToNotTrack = [
		'ad id',
		'id'
	];

	/**
	 * Handle the job seek ad "created" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function created(JobSeekAd $jobSeekAd)
	{
		$this->track($jobSeekAd, function ($value, $field) use ($jobSeekAd) {
			if (!in_array($field, $this->fieldToNotTrack)) {
				$fieldName = $this->fieldList[$field] ?? $field;
				return [
					'ad_id' => $jobSeekAd->ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $value . "</em>",
				];
			}
		});
	}

	/**
	 * Handle the job seek ad "updated" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function updated(JobSeekAd $jobSeekAd)
	{
		$this->track($jobSeekAd, function ($value, $field) use ($jobSeekAd) {
			$fieldName = $this->fieldList[$field] ?? $field;
			return [
				'ad_id' => $jobSeekAd->ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $value . "</em>",

			];

		});
	}

	/**
	 * Handle the job seek ad "deleted" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function deleted(JobSeekAd $jobSeekAd)
	{
		//
	}

	/**
	 * Handle the job seek ad "restored" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function restored(JobSeekAd $jobSeekAd)
	{
		//
	}

	/**
	 * Handle the job seek ad "force deleted" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function forceDeleted(JobSeekAd $jobSeekAd)
	{
		//
	}
}
