<?php

namespace App\Models;

use App\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property Department[] $departments
 */
class Region extends Model
{
    use Locationable;

    /**
     * @var array
     */
    protected $fillable = ['code', 'name', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany('App\Models\Department', 'region_code', 'code');
    }
}
