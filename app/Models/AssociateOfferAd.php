<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\EducationLevelable;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AssociateOfferAd
 *
 * @property int $id
 * @property int $accept_use_zip_code
 * @property float $surface
 * @property float|null $altitude
 * @property int $water_access
 * @property int $has_buildings
 * @property int $has_houses
 * @property string $associate_description
 * @property string|null $experience_farming
 * @property int $is_activity_transmission
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
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereAssociateDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereHasBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereIsActivityTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssociateOfferAd whereWaterAccess($value)
 *
 * @mixin \Eloquent
 */
class AssociateOfferAd extends Model
{
    use BioCertifiable,
        EducationLevelable,
        HasMorphToManyEvents,
        HasRelationshipObservables,
        ProductionableGenre;

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'accept_use_zip_code',
        'surface',
        'altitude',
        'water_access',
        'has_buildings',
        'has_houses',
        'associate_description',
        'experience_farming',
        'is_activity_transmission',
    ];
}
