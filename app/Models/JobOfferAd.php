<?php

namespace App\Models;

use App\Models\Traits\EducationLevelable;
use App\Models\Traits\JobOfferTypable;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobOfferAd
 *
 * @property int $id
 * @property int|null $is_activity_transmission
 * @property string $job_description
 * @property string|null $experience_farming
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgriculturalActivity[] $agriculturalActivity
 * @property-read int|null $agricultural_activity_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereIsActivityTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereJobDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property string|null $secondary_production_type_add
 * @property string|null $production_type_add
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobOfferAd whereSecondaryProductionTypeAdd($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresSecondary
 * @property-read int|null $production_genres_secondary_count
 */
class JobOfferAd extends Model
{
    use EducationLevelable,
        HasMorphToManyEvents,
        HasRelationshipObservables,
        JobOfferTypable,
        ProductionableGenre;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'is_activity_transmission',
        'experience_farming',
        'job_description',
        'secondary_production_type_add',
        'production_type_add',
        // 'is_beneficiary',
        // 'education_level_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function agriculturalActivity()
    {
        return $this->belongsToMany(AgriculturalActivity::class)->withTimestamps();
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
