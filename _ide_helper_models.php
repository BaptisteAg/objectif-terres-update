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
 * App\Models\Ad
 *
 * @property int $id
 * @property int $user_pp_id
 * @property int $is_draft
 * @property int $accept_share_contact_infos
 * @property string|null $title
 * @property string|null $about_content
 * @property string|null $about_project_content
 * @property int|null $project_id
 * @property string|null $support_request_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \App\Models\AttributionAd $attributionAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavoriteAd[] $favoriteAds
 * @property-read int|null $favorite_ads_count
 * @property-read \App\Models\JobOfferAd $jobOfferAd
 * @property-read \App\Models\JobSeekAd $jobSeekAd
 * @property-read \App\Models\LandOfferAd $landOfferAd
 * @property-read \App\Models\LandSeekAd $landSeekAd
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\Thread $threadAlreadyExist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \App\Models\User $userPp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutProjectContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAcceptShareContactInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereSupportRequestText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUserPpId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad withoutTrashed()
 * @mixin \Eloquent
 */
	class Ad extends \Eloquent implements \McCool\LaravelAutoPresenter\HasPresenter, \McCool\LaravelAutoPresenter\Decoratable {}
}

namespace App\Models{
/**
 * App\Models\AdNote
 *
 * @property int $id
 * @property int $ad_id
 * @property int $user_id
 * @property int|null $project_data_key_id
 * @property int|null $project_data_value_id
 * @property string $value
 * @property string|null $contact_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\ProjectDataKey|null $projectDataKey
 * @property-read \App\Models\ProjectDataValue|null $projectDataValue
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereProjectDataKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereProjectDataValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereValue($value)
 * @mixin \Eloquent
 */
	class AdNote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $attributionAds
 * @property-read int|null $attribution_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AgriculturalActivity
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferAd[] $jobOfferAds
 * @property-read int|null $job_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AgriculturalActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AttributionAd
 *
 * @property int $id
 * @property int|null $user_advisor_id
 * @property int|null $user_moderator_id
 * @property int|null $user_supervisor_id
 * @property int $ad_id
 * @property int|null $ad_status_id
 * @property int|null $refusal_type_id
 * @property string|null $published_on
 * @property string|null $refused_on
 * @property string|null $archived_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\AdStatus|null $adStatus
 * @property-read \App\Models\RefusalType|null $refusalType
 * @property-read \App\Models\User|null $userAdvisor
 * @property-read \App\Models\User|null $userModerator
 * @property-read \App\Models\User|null $userSupervisor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePublishedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserAdvisorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserSupervisorId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusedOn($value)
 */
	class AttributionAd extends \Eloquent implements \McCool\LaravelAutoPresenter\Decoratable {}
}

namespace App\Models{
/**
 * App\Models\BioCertification
 *
 * @property int $id
 * @property string $name
 * @property string $icon
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BioCertification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Building
 *
 * @property int $id
 * @property string|null $description
 * @property float|null $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd $landOfferAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Building whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Building extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildingType
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuildingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildingType extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereGpsLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereInseeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereZipCode($value)
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CmsPage
 *
 * @property int $id
 * @property string $page_name
 * @property string $description
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage wherePageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CmsPage whereUpdatedAt($value)
 */
	class CmsPage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property int $code
 * @property string $alpha2
 * @property string $alpha3
 * @property string $name_en_gb
 * @property string $name_fr_fr
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereAlpha2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereAlpha3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNameEnGb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNameFrFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Country extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\Region $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereSlug($value)
 * @mixin \Eloquent
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $type
 * @property int $size
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $ads
 * @property-read int|null $ads_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUserId($value)
 * @mixin \Eloquent
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EducationLevel
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferAd[] $jobOfferAds
 * @property-read int|null $job_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class EducationLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FavoriteAd
 *
 * @property int $id
 * @property int $user_id
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereUserId($value)
 * @mixin \Eloquent
 */
	class FavoriteAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\House
 *
 * @property int $id
 * @property string|null $description
 * @property float|null $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd $landOfferAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class House extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InstallationType
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class InstallationType extends \Eloquent {}
}

namespace App\Models{
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereIsActivityTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereJobDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JobOfferAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JobOfferType
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $Researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferAd[] $jobOfferAds
 * @property-read int|null $job_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JobOfferType extends \Eloquent {}
}

namespace App\Models{
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobSeekAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JobSeekAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Land
 *
 * @property int $id
 * @property string $area
 * @property int|null $price
 * @property string|null $land_availability
 * @property string|null $land_transfer_deadline
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd $landOfferAds
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
 * @mixin \Eloquent
 */
	class Land extends \Eloquent {}
}

namespace App\Models{
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
 * @property float|null $price
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
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \App\Models\Building|null $building
 * @property-read \App\Models\House|null $house
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHasBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsActivityTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationCommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTerreDeLiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTestArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereProductionTypeWantedAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereRentPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereSauDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereTestDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccessDescription($value)
 * @mixin \Eloquent
 */
	class LandOfferAd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LandSeekAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int|null $installation_type_id
 * @property int|null $is_bio
 * @property string|null $production_type_add
 * @property string|null $land_description
 * @property string|null $experience_farming
 * @property int|null $surface_range_min
 * @property int|null $surface_range_max
 * @property int|null $price_max
 * @property int|null $rent_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAdBuilding[] $buildings
 * @property-read int|null $buildings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \App\Models\InstallationType|null $installationType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereInstallationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereIsBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereLandDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereRentMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class LandSeekAd extends \Eloquent {}
}

namespace App\Models{
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
	class LandSeekAdBuilding extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property int $id
 * @property string|null $content
 * @property int $thread_id
 * @property int $sender_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\User $senderUser
 * @property-read \App\Models\Thread $thread
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReadMessage[] $unreadMessages
 * @property-read int|null $unread_messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSenderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Message extends \Eloquent implements \McCool\LaravelAutoPresenter\HasPresenter, \McCool\LaravelAutoPresenter\Decoratable {}
}

namespace App\Models{
/**
 * App\Models\OfferGenre
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string $land_offer_label
 * @property int $land_seek_display
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereLandOfferLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereLandSeekDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OfferGenre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductionGenre
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @property-read \App\Models\ProductionGenre $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductionGenre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @property int $id
 * @property int|null $support_stage_id
 * @property int|null $support_state_id
 * @property int|null $project_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\ProjectStatus|null $projectStatus
 * @property-read \App\Models\SupportStage|null $supportStage
 * @property-read \App\Models\SupportState|null $supportState
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProjectStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSupportStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSupportStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Project extends \Eloquent implements \McCool\LaravelAutoPresenter\Decoratable {}
}

namespace App\Models{
/**
 * App\Models\ProjectDataKey
 *
 * @property int $id
 * @property string $name
 * @property int $is_public
 * @property int $immutable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectDataValue[] $projectDataValues
 * @property-read int|null $project_data_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereImmutable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProjectDataKey extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProjectDataValue
 *
 * @property int $id
 * @property int $project_data_key_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectDataKey $projectDataKey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereProjectDataKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereValue($value)
 * @mixin \Eloquent
 */
	class ProjectDataValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProjectStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProjectStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReadMessage
 *
 * @property int $id
 * @property int $message_id
 * @property int $user_id
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereUserId($value)
 * @mixin \Eloquent
 */
	class ReadMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefusalType
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $attributionAds
 * @property-read int|null $attribution_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereUpdatedAt($value)
 * @mixin \Eloquent
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereSlug($value)
 * @mixin \Eloquent
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Requirement
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Requirement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Research
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $surface_min
 * @property string|null $surface_max
 * @property int $has_pics
 * @property int|null $has_house
 * @property int|null $price_min
 * @property int|null $price_max
 * @property string|null $ad_type
 * @property string|null $url
 * @property int $has_alert
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdStatus[] $adStatuses
 * @property-read int|null $ad_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectStatus[] $projectStatuses
 * @property-read int|null $project_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereAdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasPics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUserId($value)
 * @mixin \Eloquent
 */
	class Research extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResponseTemplate
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ResponseTemplate extends \Eloquent {}
}

namespace App\Models\Spip{
/**
 * App\Models\Spip\Article
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article query()
 * @mixin \Eloquent
 */
	class Article extends \Eloquent {}
}

namespace App\Models\Spip{
/**
 * App\Models\Spip\Auteur
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur query()
 * @mixin \Eloquent
 */
	class Auteur extends \Eloquent {}
}

namespace App\Models\Spip{
/**
 * App\Models\Spip\SpipModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel query()
 * @mixin \Eloquent
 */
	class SpipModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SupportStage
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SupportStage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SupportState
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SupportState extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SurfaceRange
 *
 * @property int $id
 * @property string $label
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereValue($value)
 * @mixin \Eloquent
 */
	class SurfaceRange extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Thread
 *
 * @property int $id
 * @property string|null $title
 * @property int $is_private
 * @property int|null $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad|null $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $unreadMessages
 * @property-read int|null $unread_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Thread extends \Eloquent implements \McCool\LaravelAutoPresenter\HasPresenter, \McCool\LaravelAutoPresenter\Decoratable {}
}

namespace App\Models{
/**
 * App\Models\ThreadUser
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereUserId($value)
 * @mixin \Eloquent
 */
	class ThreadUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $sf_id
 * @property string $name
 * @property string $first_name
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $city
 * @property int|null $civility
 * @property int|null $profile
 * @property string|null $other_profile
 * @property int $accept_communication
 * @property int $accept_share_contact_infos
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $origin
 * @property int|null $country_id
 * @property int|null $zip_code_id
 * @property int $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $is_sf_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\Ad $supportRequest
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $supportRequests
 * @property-read int|null $support_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \App\Models\City|null $zipCode
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAcceptCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAcceptShareContactInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsSfUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtherProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereZipCodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \McCool\LaravelAutoPresenter\HasPresenter, \McCool\LaravelAutoPresenter\Decoratable {}
}

