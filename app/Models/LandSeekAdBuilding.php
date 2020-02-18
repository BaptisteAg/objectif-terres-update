<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LandSeekAdBuilding
 *
 * @property int $id
 * @property int $land_seek_ad_id
 * @property int $building_type_id
 * @property int $requirement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BuildingType $buildingType
 * @property-read \App\Models\LandSeekAd $landSeekAd
 * @property-read \App\Models\Requirement $requirement
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereBuildingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereLandSeekAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereRequirementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAdBuilding whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandSeekAdBuilding extends Model
{
    protected $fillable = [
        "requirement_id",
        "building_type_id",
        "land_seek_ad_id"
    ];

    public function landSeekAd()
    {
        return $this->belongsTo(LandSeekAd::class);
    }

    public function buildingType()
    {
        return $this->belongsTo(BuildingType::class);
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}
