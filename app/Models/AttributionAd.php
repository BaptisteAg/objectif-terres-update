<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttributionAd
 *
 * @property int $id
 * @property int $ad_status_id
 * @property int $lead_type_id
 * @property int $refusal_type_id
 * @property int|null $user_owner_id
 * @property int $user_admin_id
 * @property boolean $to_call_back
 * @property string $short_description
 * @property string $archived_at
 * @property AdStatus $adStatus
 * @property PpType $ppType
 * @property RefusalType $refusalType
 * @property Ad $ads
 * @property User $userOwner
 * @property User $userAdmin
 * @property int|null $pp_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePpTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereToCallBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributionAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_status_id', 'lead_type_id', 'refusal_type_id', 'user_owner_id', 'user_admin_id', 'to_call_back', 'short_description', 'archived_at'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userOwner()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userAdmin()
	{
		return $this->belongsTo(User::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adStatus()
    {
        return $this->belongsTo(AdStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ppType()
    {
        return $this->belongsTo(PpType::class, 'lead_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refusalType()
    {
        return $this->belongsTo(RefusalType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ads()
    {
        return $this->hasOne(Ad::class );
    }
}
