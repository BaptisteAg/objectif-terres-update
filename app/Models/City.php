<?php

namespace App\Models;

use App\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $department_code
 * @property string $insee_code
 * @property string $zip_code
 * @property string $name
 * @property string $slug
 * @property float $gps_lat
 * @property float $gps_lng
 * @property Department $department
 */
class City extends Model
{
    use Locationable;
    /**
     * @var array
     */
    protected $fillable = [
        'department_code', 'insee_code', 'zip_code', 'name', 'slug', 'gps_lat', 'gps_lng'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_code', 'code');
    }
}
