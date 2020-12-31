<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Territory
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Territory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Territory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Territory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Territory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Territory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Territory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Territory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Territory extends Model
{
	use Locationable;

	protected $fillable = ['name'];

	static $territoriesIdAllowToUseService  = [1, 3, 4, 12, 15, 16, 20, 21];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function departments()
	{
		return $this->hasMany(Department::class, 'territory_id', 'id');
	}


}
