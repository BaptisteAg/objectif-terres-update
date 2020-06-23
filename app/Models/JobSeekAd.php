<?php

namespace App\Models;

use App\Models\Traits\EducationLevelable;
use App\Models\Traits\JobOfferTypable;
use App\Models\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobSeekAd
 *
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd query()
 * @mixin \Eloquent
 */
class JobSeekAd extends Model
{
    use JobOfferTypable;
    use EducationLevelable;
    use OfferableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
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
