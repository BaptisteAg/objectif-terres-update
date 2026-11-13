<?php

namespace App\Nova\Filters;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Filters\Filter;

class LikelyBotFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public $name = 'Score Bot';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        if ($value === 'likely_bot') {
            return $query->likelyBot(0.3);
        }

        if ($value === 'suspicious') {
            return $query->likelyBot(0.5);
        }

        if ($value === 'has_score') {
            return $query->whereHas('sentMessages', function ($q) {
                $q->whereNotNull('recaptcha_score');
            });
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            'Bot probable (score < 0.3)' => 'likely_bot',
            'Suspect (score < 0.5)' => 'suspicious',
            'A un score reCAPTCHA' => 'has_score',
        ];
    }
}
