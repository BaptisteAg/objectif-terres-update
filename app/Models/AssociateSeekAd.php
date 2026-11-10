<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\EducationLevelable;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AssociateSeekAd
 *
 * @property int $id
 * @property int|null $is_land_already_found
 * @property string $land_description
 * @property string $associate_description
 * @property string|null $experience_farming
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresSecondary
 * @property-read int|null $production_genres_secondary_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereAssociateDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereIsLandAlreadyFound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereLandDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateSeekAd whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AssociateSeekAd extends Model
{
    use BioCertifiable,
        EducationLevelable,
        HasMorphToManyEvents,
        HasRelationshipObservables,
        ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'is_land_already_found',
        'land_description',
        'associate_description',
        'experience_farming',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
