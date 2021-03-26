<?php

namespace App\Observers;

use App\Models\LandSeekAd;
use App\Observers\Traits\SubAdHistoryObserverTrait;

class LandSeekAdObserver
{
	use SubAdHistoryObserverTrait;

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

		$this->createdObserverSubAd($landSeekAd, $this->fieldToNotTrack);
	}

	/**
	 * Handle the land seek ad "updated" event.
	 *
	 * @param LandSeekAd $landSeekAd
	 * @return void
	 */
	public function updated(LandSeekAd $landSeekAd)
	{

		$this->updatedObserverSubAd($landSeekAd);

	}

	public function updating(LandSeekAd $landSeekAd){

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
