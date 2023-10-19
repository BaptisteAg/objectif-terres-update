<?php

namespace App\Models;

use App\Models\Scopes\ScopeLocationFilterable;
use App\Notifications\ResetPasswordNotification;
use App\Presenters\UserPresenter;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use McCool\LaravelAutoPresenter\HasPresenter;

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
 * @property-read \App\Models\Ad|null $supportRequest
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $supportRequests
 * @property-read int|null $support_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserPermission[] $userPermissions
 * @property-read int|null $user_permissions_count
 * @property-read \App\Models\City|null $zipCode
 * @method static \Illuminate\Database\Eloquent\Builder|User filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterRegions($regionCode)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|User filterSupportRequestRegionId($territoriesId, $userRole)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAcceptCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAcceptShareContactInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSfUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtherProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereZipCodeId($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $adsAdvisor
 * @property-read int|null $ads_advisor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $adsModerator
 * @property-read int|null $ads_moderator_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $adsSupervisor
 * @property-read int|null $ads_supervisor_count
 * @property int|null $birthday
 * @property int|null $formation
 * @property int|null $fromwhere
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFormation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFromwhere($value)
 */
class User extends Authenticatable implements HasPresenter, MustVerifyEmail
{
	use Notifiable;
	use CanResetPassword;
	use SoftDeletes;
	use ScopeLocationFilterable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'first_name',
        'birthday',
        'formation',
        'fromwhere',
		'phone',
		'street',
		'city',
		'zip_code_id',
		'accept_communication',
		'country_id',
		'profile',
		'civility',
		'profile',
		'other_profile',
		'accept_share_contact_infos',
		'role',
		'is_blocked',
		'deleted_at ',
		'origin',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	static $civilities = [
		1 => "Madame",
		2 => "Monsieur",
		3 => "Autre",
	];

	static $profiles = [
		1 => "candidat à l‘installation",
		2 => "personne en recherche d’expérience ou de travail dans le domaine agricole",
		3 => "un agriculteur qui souhaite consolider sa ferme",
		4 => "un agriculteur qui souhaite transmettre sa ferme",
		5 => "un propriétaire privé qui souhaite vendre ou louer sa ferme",
		6 => "un propriétaire privé qui souhaite donner ou léguer sa ferme",
		7 => "autre",
	];

	static $roles = [
		0 => "Porteur de projet",
		1 => "Modérateur",
		2 => "Primo-accueillant",
		3 => "Responsable territorial",
		4 => "Administrateur",
	];

    static $formations = [
        0 => "Diplôme agricole niveau III (BEPA)",
        1 => "Diplôme agricole niveau IV (BPREA, BAC,)",
        2 => "Diplôme agricole niveau V (BTS, DUT) ",
        3 => "Diplôme agricole niveau VI (licence,)",
        4 => "Diplôme agricole niveau VII ou plus (ingénieur, master2, véto, ...)",
    ];

    static $fromwheres = [
		0 => "Issu du monde agricole",
		1 => "Non Issu du monde agricole",
		2 => "Ne sait pas répondre à la question"
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function country()
	{
		return $this->belongsTo('App\Models\Country');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function zipCode()
	{
		return $this->belongsTo('App\Models\City');
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param string $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));

	}

	public function threads(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
	{
		return $this->belongsToMany(Thread::class, 'thread_users')->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function ads()
	{
		return $this->hasMany(Ad::class, 'user_pp_id', 'id')->whereNull('project_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
	 */
	public function supportRequests()
	{
		return $this->hasMany(Ad::class, 'user_pp_id', 'id')->whereNotNull('project_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Query\Builder
	 */
	public function supportRequest()
	{
		return $this->hasOne(Ad::class, 'user_pp_id', 'id')->whereNotNull('project_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function adsModerator()
	{
		return $this->hasMany(AttributionAd::class, "user_moderator_id", 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function adsSupervisor()
	{
		return $this->hasMany(AttributionAd::class, "user_supervisor_id", 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function adsAdvisor()
	{
		return $this->hasMany(AttributionAd::class, "user_advisor_id", 'id');
	}


	/**
	 * Get the presenter class.
	 *
	 * @return string
	 */
	public function getPresenterClass()
	{
		return UserPresenter::class;
	}

	/**
	 * Get all cities 'location' for the user
	 * @return MorphToMany
	 */
	public function cities()
	{
		return $this->morphedbyMany(City::class, 'locationable_user');
	}

	/**
	 * Get all departments 'location' for the user
	 * @return MorphToMany
	 */
	public function departments()
	{
		return $this->morphedbyMany(Department::class, 'locationable_user');
	}


	/**
	 * Get all regions 'location' for the user
	 * @return MorphToMany
	 */
	public function regions()
	{
		return $this->morphedbyMany(Region::class, 'locationable_user');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function userPermissions()
	{
		return $this->hasMany(UserPermission::class, 'user_id');
	}
}
