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


/**
 * App\Models\LandOfferAd
 *
 * @property int $id
 * @property int $accept_use_zip_code
 * @property float $surface
 * @property string|null $sau_description
 * @property int|null $water_access
 * @property string|null $water_access_description
 * @property float|null $altitude
 * @property int|null $has_buildings
 * @property int|null $has_houses
 * @property float|null $rent_price
 * @property string|null $test_description
 * @property int $ad_id
 * @property int|null $building_id
 * @property int|null $house_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_beneficiary
 * @property int|null $is_activity_transfer
 * @property int|null $is_call_for_application_community
 * @property int|null $is_call_for_application_terre_de_liens
 * @property int|null $is_call_for_application_test_area
 * @property string|null $production_type_add
 * @property string|null $production_type_wanted_add
 * @property float|null $price
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \App\Models\Building|null $building
 * @property-read \App\Models\House|null $house
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresSecondary
 * @property-read int|null $production_genres_possible_count
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereHasBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereHouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereIsActivityTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereIsCallForApplicationCommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereIsCallForApplicationTerreDeLiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereIsCallForApplicationTestArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereProductionTypeWantedAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereRentPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereSauDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereTestDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereWaterAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereWaterAccessDescription($value)
 * @mixin \Eloquent
 * @property string|null $secondary_production_type_add
 * @method static \Illuminate\Database\Eloquent\Builder|LandOfferAd whereSecondaryProductionTypeAdd($value)
 */
class LandOfferAd extends Model
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
		'surface',
		'sau_description',
		'accept_use_zip_code',
		'water_access',
		'water_access_description',
		'altitude',
		'has_buildings',
		'has_houses',
		'price',
		'rent_price',
		'test_description',
		'building_id',
		'house_id',
		'production_type_add',
		'production_type_wanted_add',
		'is_beneficiary',
		'is_activity_transfer',
		'is_call_for_application_community',
		'is_call_for_application_terre_de_liens',
		'is_call_for_application_test_area',
        'secondary_production_type_add',
        'is_sales_offer_evaluation'
	];
}
