<?php

namespace App\Models;

use App\Models\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

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
class Department extends Model
{
    use Locationable;

    /**
     * @var array
     */
    protected $fillable = [
        'region_code', 'code', 'name', 'slug', 'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'department_code', 'code');
    }
}
