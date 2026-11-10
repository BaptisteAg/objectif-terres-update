<?php

namespace App\Observers;

use App\Models\JobSeekAd;
use App\Observers\Traits\ObserverRelationsTrait;

class JobSeekAdObserver
{
    use ObserverRelationsTrait;

    private $fieldList = [
        'experience farming' => 'expérience agricole',
    ];

    private $fieldToNotTrack = [
        'ad id',
        'id',
    ];

    /**
     * Handle the job seek ad "created" event.
     *
     * @return void
     */
    public function created(JobSeekAd $jobSeekAd)
    {
        $this->createdObserverSubAd($jobSeekAd, $this->fieldToNotTrack);
    }

    /**
     * Handle the job seek ad "updated" event.
     *
     * @return void
     */
    public function updated(JobSeekAd $jobSeekAd)
    {
        $this->updatedObserverSubAd($jobSeekAd);
    }

    public function morphToManyAttaching(string $relation, JobSeekAd $jobSeekAd, array $ids, array $attributes)
    {
        $this->morphToManySubAdObserver($relation, $jobSeekAd, $ids);
    }

    /**
     * Handle the job seek ad "deleted" event.
     *
     * @return void
     */
    public function deleted(JobSeekAd $jobSeekAd)
    {
        //
    }

    /**
     * Handle the job seek ad "restored" event.
     *
     * @return void
     */
    public function restored(JobSeekAd $jobSeekAd)
    {
        //
    }

    /**
     * Handle the job seek ad "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(JobSeekAd $jobSeekAd)
    {
        //
    }
}
