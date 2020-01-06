<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ad_status_id
 * @property int $lead_type_id
 * @property int $refusal_type_id
 * @property string $sf_owner_id
 * @property string $sf_admin_id
 * @property boolean $to_call_back
 * @property string $short_description
 * @property string $archived_at
 * @property AdStatus $adStatus
 * @property PpType $ppType
 * @property RefusalType $refusalType
 * @property Ad $ads
 */
class AttributionAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_status_id', 'lead_type_id', 'refusal_type_id', 'sf_owner_id', 'sf_admin_id', 'to_call_back', 'short_description', 'archived_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adStatus()
    {
        return $this->belongsTo('App\Models\AdStatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ppType()
    {
        return $this->belongsTo('App\Models\PpType', 'lead_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refusalType()
    {
        return $this->belongsTo('App\Models\RefusalType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ads()
    {
        return $this->hasOne('App\Models\Ad');
    }
}
