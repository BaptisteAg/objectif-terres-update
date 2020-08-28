<?php

namespace App\Models;

use App\Models\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGpsLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereInseeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereZipCode($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use Locationable;
    /**
     * @var array
     */
    protected $fillable = [
        'id','department_code', 'insee_code', 'zip_code', 'name', 'slug', 'gps_lat', 'gps_lng'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }
}
