<?php

namespace App\Nova\Metrics;

use App\Models\Ad;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class SurveyCount extends Value
{
    public function name()
    {
        return 'Réponses enquête';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Ad::withTrashed(), 'survey_submitted_at', 'survey_submitted_at');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 jours',
            60 => '60 jours',
            365 => '365 jours',
            'TODAY' => "Aujourd'hui",
            'MTD' => 'Depuis un mois',
            'QTD' => 'Depuis 4 mois',
            'YTD' => 'Depuis cette année',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'survey-count';
    }
}
