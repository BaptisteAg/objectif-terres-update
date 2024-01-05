<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\EducationLevelable;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Model;

class AssociateSeekAd extends Model
{
    use ProductionableGenre,
		EducationLevelable,
        BioCertifiable,
		HasMorphToManyEvents,
		HasRelationshipObservables;

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
