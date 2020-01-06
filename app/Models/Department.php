<?php

namespace App\Models;

use App\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $region_code
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property Region $region
 * @property City[] $cities
 */
class Department extends Model
{
    use Locationable;

    /**
     * @var array
     */
    protected $fillable = [
        'region_code', 'code', 'name', 'slug'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City', 'department_code', 'code');
    }
}
