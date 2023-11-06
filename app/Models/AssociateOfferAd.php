<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


class AssociateOfferAd extends Model
{
	use ProductionableGenre,
        BioCertifiable,
		OfferableGenre,
		HasMorphToManyEvents,
		HasRelationshipObservables;

	public function ad()
	{
		return $this->belongsTo(Ad::class);
	}

	public function building()
	{
		return $this->belongsTo(Building::class);
	}

	public function house()
	{
		return $this->belongsTo(House::class);
	}

	public static function boot()
	{
		parent::boot();

		/**
		 * Many To Many Polymorphic Relationship Events
		 */

		static::morphToManyAttaching(function ($relation, $parent, $ids, $attributes) {
		});
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
