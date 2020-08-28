<?php

namespace App\Models;

use App\Models\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereSlug($value)
 * @mixin \Eloquent
 */
class Region extends Model
{
    use Locationable;

    /**a
     * @var array
     */
    protected $fillable = ['code', 'name', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'region_code', 'code');
    }
}
