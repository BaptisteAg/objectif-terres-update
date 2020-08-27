<?php

namespace App\Models;

use App\Models\Scopes\ScopeLocationFilterable;
use App\Notifications\ResetPasswordNotification;
use App\Presenters\UserPresenter;
use Illuminate\Auth\Passwords\CanResetPassword;
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
 * @property-read \App\Models\Ad $supportRequest
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $supportRequests
 * @property-read int|null $support_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserPermission[] $userPermissions
 * @property-read int|null $user_permissions_count
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
class User extends Authenticatable implements HasPresenter
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
		1 => "Porteur de projet en recherche de terres",
		2 => "Porteur de projet en recherche de financement",
		3 => "En reconversion professionnelle et à la recherche des informations pour m’installer",
		4 => "A la recherche d’un travail / d’une expérience dans le domaine agricole",
		5 => "Agriculteur qui souhaite transmettre ma ferme",
		6 => "Agriculteur en activité qui cherche à consolider ma ferme",
		7 => "Propriétaire privé qui cherche à vendre ou louer mes terres",
		8 => "Autre",
	];

	static $roles = [
		0 => "Porteur de projet",
		1 => "Modérateur",
		2 => "Primo-accueillant",
		3 => "Responsable territorial",
		4 => "Administrateur",
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
