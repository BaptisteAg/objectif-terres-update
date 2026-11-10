<?php

namespace Laravel\Nova\Metrics;

use Closure;
use JsonSerializable;

class PartitionResult implements JsonSerializable
{
    /**
     * The value of the result.
     *
     * @var array
     */
    public $value;

    /**
     * The custom label colors.
     *
     * @var array
     */
    public $colors = [];

    /**
     * Create a new partition result instance.
     *
     * @return void
     */
    public function __construct(array $value)
    {
        $this->value = $value;
        $this->colors = new PartitionColors;
    }

    /**
     * Format the labels for the partition result.
     *
     * @return $this
     */
    public function label(Closure $callback)
    {
        $this->value = collect($this->value)->mapWithKeys(function ($value, $label) use ($callback) {
            return [$callback($label) => $value];
        })->all();

        return $this;
    }

    /**
     * Set the custom label colors.
     *
     * @return $this
     */
    public function colors(array $colors)
    {
        $this->colors = new PartitionColors($colors);

        return $this;
    }

    /**
     * Prepare the metric result for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'value' => collect($this->value ?? [])->map(function ($value, $label) {
                return array_filter([
                    'color' => $this->colors->get($label),
                    'label' => $label,
                    'value' => $value,
                ], function ($value) {
                    return ! is_null($value);
                });
            })->values()->all(),
        ];
    }
}
