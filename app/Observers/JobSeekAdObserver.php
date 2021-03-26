<?php

namespace App\Observers;

use App\Models\JobSeekAd;
use App\Observers\Traits\SubAdHistoryObserverTrait;
use App\Observers\Traits\TracksHistoryTrait;

class JobSeekAdObserver
{
	use SubAdHistoryObserverTrait;

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
		$this->createdObserverSubAd($jobSeekAd, $this->fieldToNotTrack);
	}

	/**
	 * Handle the job seek ad "updated" event.
	 *
	 * @param JobSeekAd $jobSeekAd
	 * @return void
	 */
	public function updated(JobSeekAd $jobSeekAd)
	{
		$this->updatedObserverSubAd($jobSeekAd);
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
