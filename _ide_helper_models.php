<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AdRequest
 *
 * @property int $id
 * @property int $attribution_ad_id
 * @property int $project_id
 * @property string $sf_pp_id
 * @property string $sf_admin_id
 * @property boolean $is_draft
 * @property string $about_content
 * @property string $about_project_content
 * @property AttributionAd $attributionAd
 * @property Project $project
 * @property AdMessage[] $adMessages
 * @property AdNote[] $adNotes
 * @property JobOfferAd $jobAds
 * @property LandOfferAd $landOfferAds
 * @property LandSeekAd $landSeekAds
 * @property PpToUserMessage[] $ppToUserMessages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $ad_messages_count
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavoriteAd[] $favoriteAd
 * @property-read int|null $favorite_ad_count
 * @property-read int|null $pp_to_user_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutProjectContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAttributionAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereSfAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereSfPpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 */
	class Ad extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdMessages
 *
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_sender_id
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereSfSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereUpdatedAt($value)
 */
	class AdMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdNote
 *
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_user_id
 * @property string $contact_name
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereSfUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUpdatedAt($value)
 */
	class AdNote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdStatus
 *
 * @property int $id
 * @property string $name
 * @property Research[] $researches
 * @property AttributionAd[] $attributionAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attribution_ads_count
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereUpdatedAt($value)
 */
	class AdStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AgriculturalActivity
 *
 * @property int $id
 * @property string $name
 * @property JobOfferAd[] $jobAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $job_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereUpdatedAt($value)
 */
	class AgriculturalActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AttributionAd
 *
 * @property int $id
 * @property int $ad_status_id
 * @property int $lead_type_id
 * @property int $refusal_type_id
 * @property string $sf_owner_id
 * @property string $sf_admin_id
 * @property boolean $to_call_back
 * @property string $short_description
 * @property string $archived_at
 * @property AdStatus $adStatus
 * @property PpType $ppType
 * @property RefusalType $refusalType
 * @property Ad $ads
 * @property int|null $pp_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePpTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereSfAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereSfOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereToCallBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUpdatedAt($value)
 */
	class AttributionAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BioCertification
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereUpdatedAt($value)
 */
	class BioCertification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Building
 *
 * @property int $id
 * @property int $number
 * @property float $surface
 * @property float $price
 * @property LandOfferAd $landOfferAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereUpdatedAt($value)
 */
	class Building extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $department_code
 * @property string $insee_code
 * @property string $zip_code
 * @property string $name
 * @property string $slug
 * @property float $gps_lat
 * @property float $gps_lng
 * @property Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City query()
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $region_code
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property Region $region
 * @property City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $path
 * @property string $type_document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $ads
 * @property-read int|null $ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereTypeDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EducationLevel
 *
 * @property int $id
 * @property string $name
 * @property JobOfferAd[] $jobAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $job_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereUpdatedAt($value)
 */
	class EducationLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FavoriteAd
 *
 * @property int $id
 * @property int $ad_id
 * @property string $sf_id
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereUpdatedAt($value)
 */
	class FavoriteAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\House
 *
 * @property int $id
 * @property int $number
 * @property float $surface
 * @property float $price
 * @property LandOfferAd $landOfferAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereUpdatedAt($value)
 */
	class House extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InstallationType
 *
 * @property int $id
 * @property string $name
 * @property LandSeekAd[] $landSeekAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereUpdatedAt($value)
 */
	class InstallationType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JobAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int $education_level_id
 * @property int $job_status_id
 * @property string $title
 * @property boolean $is_offer
 * @property boolean $is_beneficiary
 * @property int $experience_farming
 * @property string $about_project_content
 * @property Ad $ad
 * @property EducationLevel $educationLevel
 * @property JobStatus $jobStatus
 * @property AgriculturalActivity[] $agriculturalActivity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $agricultural_activity_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereEducationLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereIsOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereJobStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereUpdatedAt($value)
 */
	class JobAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JobStatus
 *
 * @property int $id
 * @property string $name
 * @property JobOfferAd[] $jobAds
 * @property Research[] $researches
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $Researches
 * @property-read int|null $researches_count
 * @property-read int|null $job_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereUpdatedAt($value)
 */
	class JobStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Land
 *
 * @property int $id
 * @property float $area
 * @property float $price
 * @property string $land_availability
 * @property string $land_transfer_deadline
 * @property LandOfferAd $landOfferAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereLandAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereLandTransferDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereUpdatedAt($value)
 */
	class Land extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LandOfferAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int $building_id
 * @property int $house_id
 * @property int $land_id
 * @property boolean $is_beneficiary
 * @property boolean $accept_use_zip_code
 * @property boolean $is_call_for_application_community
 * @property boolean $is_call_for_application_terre_de_liens
 * @property boolean $is_call_for_application_test_area
 * @property boolean $is_activity_transfert
 * @property string $water_access
 * @property int $altitude
 * @property Ad $ad
 * @property Building $building
 * @property House $house
 * @property Land $land
 * @property int|null $is_activity_transfer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsActivityTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationCommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTerreDeLiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTestArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereLandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccess($value)
 */
	class LandOfferAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LandSeekAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int $installation_type_id
 * @property int $offer_type_id
 * @property string $title
 * @property boolean $is_bio
 * @property string $production_type_add
 * @property boolean $has_farm_buildings
 * @property boolean $has_houses
 * @property string $experience_farming
 * @property float $rent_min
 * @property float $rent_max
 * @property Ad $ad
 * @property InstallationType $installationType
 * @property OfferGenre $offerGenre
 * @property PriceRange[] $priceRanges
 * @property SurfaceRange[] $surfaceRanges
 * @property int|null $offer_genre_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $price_ranges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read int|null $surface_ranges_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereHasFarmBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereInstallationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereIsBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereOfferGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereRentMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereRentMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereUpdatedAt($value)
 */
	class LandSeekAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OfferGenre
 *
 * @property int $id
 * @property string $name
 * @property LandSeekAd[] $landSeekAds
 * @property Building[] $buildings
 * @property House[] $houses
 * @property Land[] $lands
 * @property Research[] $researches
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $buildings_count
 * @property-read int|null $houses_count
 * @property-read int|null $land_seek_ads_count
 * @property-read int|null $lands_count
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereUpdatedAt($value)
 */
	class OfferGenre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PpToUserMessage
 *
 * @property int $id
 * @property int $ad_id
 * @property string $sf_sender_id
 * @property string $sf_receiver_id
 * @property string $content
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereSfReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereSfSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUpdatedAt($value)
 */
	class PpToUserMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PpType
 *
 * @property int $id
 * @property string $name
 * @property AttributionAd[] $attributionAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attribution_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereUpdatedAt($value)
 */
	class PpType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PriceRange
 *
 * @property int $id
 * @property string $price
 * @property LandSeekAd[] $landSeekAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereUpdatedAt($value)
 */
	class PriceRange extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductionGenre
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereUpdatedAt($value)
 */
	class ProductionGenre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @property int $id
 * @property int $project_status_id
 * @property ProjectStatus $projectStatus
 * @property Ad[] $ads
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProjectStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProjectStatus
 *
 * @property int $id
 * @property string $name
 * @property Research[] $researches
 * @property Project[] $projects
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $projects_count
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereUpdatedAt($value)
 */
	class ProjectStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefusalType
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property AttributionAd[] $attributionAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attribution_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereUpdatedAt($value)
 */
	class RefusalType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property Department[] $departments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region query()
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Research
 *
 * @property int $id
 * @property string $sf_id
 * @property string $name
 * @property int $surface_min
 * @property int $surface_max
 * @property boolean $has_pics
 * @property boolean $has_house
 * @property int $price_min
 * @property int $price_max
 * @property JobStatus[] $jobStatuses
 * @property ProjectStatus[] $projectStatuses
 * @property AdStatus[] $adStatuses
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $ad_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read int|null $job_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read int|null $project_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasPics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUpdatedAt($value)
 */
	class Research extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResponseType
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereUpdatedAt($value)
 */
	class ResponseType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SurfaceRange
 *
 * @property int $id
 * @property string $surface
 * @property LandSeekAd[] $landSeekAd
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereUpdatedAt($value)
 */
	class SurfaceRange extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserToUserMessage
 *
 * @property int $id
 * @property string $sf_user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereSfUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereUpdatedAt($value)
 */
	class UserToUserMessage extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 */
	class User extends \Eloquent {}
}

