<?php

namespace App\Nova\Metrics;

use App\Models\Ad;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class SurveyResults extends Partition
{
    public function name()
    {
        return 'Enquête de succès';
    }

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $query = Ad::withTrashed()->whereNotNull('survey_submitted_at');

        // Check if there are any results to avoid empty partition error
        if ($query->count() === 0) {
            return $this->result([
                'Aucune réponse' => 0,
            ]);
        }

        return $this->count($request, $query, 'survey_success_via_platform')
            ->label(function ($value) {
                switch ($value) {
                    case 'oui':
                        return 'Oui - Succès via OT';
                    case 'non':
                        return 'Non - Pas via OT';
                    default:
                        return $value ?? 'Non répondu';
                }
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int
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
        return 'survey-results';
    }
}
