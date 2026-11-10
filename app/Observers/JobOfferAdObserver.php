<?php

namespace App\Observers;

use App\Models\JobOfferAd;
use App\Observers\Traits\ObserverRelationsTrait;

class JobOfferAdObserver
{
    use ObserverRelationsTrait;

    private $fieldList = [
        'is activity transmission' => ' transmission ou d\'une possibilité de transmission de l\'activité agricole',
        'experience farming' => 'expérience souhaitée dans le milieu agricole',
        'job description' => 'description du poste',
    ];

    private $valueList = [
        0 => 'oui',
        1 => 'non',
    ];

    private $fieldToNotTrack = [
        'ad id',
        'id',
    ];

    /**
     * Handle the job offer ad "created" event.
     *
     * @return void
     */
    public function created(JobOfferAd $jobOfferAd)
    {
        $this->createdObserverSubAd($jobOfferAd, $this->fieldToNotTrack);
    }

    /**
     * Handle the job offer ad "updated" event.
     *
     * @return void
     */
    public function updated(JobOfferAd $jobOfferAd)
    {
        $this->updatedObserverSubAd($jobOfferAd);
    }

    public function morphToManyAttaching(string $relation, JobOfferAd $jobOfferAd, array $ids, array $attributes)
    {
        $this->morphToManySubAdObserver($relation, $jobOfferAd, $ids);
    }

    /**
     * Handle the job offer ad "deleted" event.
     *
     * @return void
     */
    public function deleted(JobOfferAd $jobOfferAd)
    {
        //
    }

    /**
     * Handle the job offer ad "restored" event.
     *
     * @return void
     */
    public function restored(JobOfferAd $jobOfferAd)
    {
        //
    }

    /**
     * Handle the job offer ad "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(JobOfferAd $jobOfferAd)
    {
        //
    }
}
