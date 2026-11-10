<?php

namespace App\Models;

use App\Models\Traits\EducationLevelable;
use App\Models\Traits\JobOfferTypable;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobSeekAd
 *
 * @property int $id
 * @property string $experience_farming
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property string|null $secondary_production_type_add
 * @property string|null $production_type_add
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobSeekAd whereSecondaryProductionTypeAdd($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresSecondary
 * @property-read int|null $production_genres_secondary_count
 */
class JobSeekAd extends Model
{
    use EducationLevelable,
        HasMorphToManyEvents,
        HasRelationshipObservables,
        JobOfferTypable,
        ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'experience_farming',
        'secondary_production_type_add',
        'production_type_add',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public static function boot()
    {
        parent::boot();

        /**
         * Many To Many Polymorphic Relationship Events
         */
        static::morphToManyAttaching(function ($relation, $parent, $ids, $attributes) {});
    }
}
