<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ThirdPartyAdUser
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ads
 * @property-read int|null $ads_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThirdPartyAdUser whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ThirdPartyAdUser extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }
}
