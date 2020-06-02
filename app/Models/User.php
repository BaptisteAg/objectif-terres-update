<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Presenters\UserPresenter;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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
 * @property string|null $address
 * @property string|null $city
 * @property int|null $civility
 * @property int|null $profile
 * @property string|null $other_profile
 * @property int $accept_communication
 * @property int $accept_share_contact_infos
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $country_id
 * @property int|null $zip_code_id
 * @property int $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \App\Models\City|null $zipCode
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAcceptCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAcceptShareContactInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtherProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereZipCodeId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasPresenter
{
	use Notifiable;
	use CanResetPassword;

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
		'address',
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
		1 => "un candidat à l’installation agricole",
		2 => "une personne en recherche de travail ou d’expérience professionnelle dans le domaine agricole",
		3 => "un agriculteur qui souhaite consolider sa ferme",
		4 => "un agriculteur qui souhaite transmettre sa ferme",
		5 => "un propriétaire foncier qui souhaite vendre ou louer sa terre",
		6 => "autre",
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

	public function threads()
	{
		return $this->belongsToMany(Thread::class, 'thread_users')->withTimestamps();
	}

	public function ads()
    {
        return $this->hasMany(Ad::class, 'user_pp_id', 'id')->whereNull('project_id');
    }

	public function supportRequests()
    {
        return $this->hasMany(Ad::class, 'user_pp_id', 'id')->whereNotNull('project_id');
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
	 * Get all cities 'location' for the user
	 * @return MorphToMany
	 */
	public function departments()
	{
		return $this->morphedbyMany(Department::class, 'locationable_user');
	}

	/**
	 * Get all cities 'location' for the user
	 * @return MorphToMany
	 */
	public function regions()
	{
		return $this->morphedbyMany(Region::class, 'locationable_user');
	}


}
