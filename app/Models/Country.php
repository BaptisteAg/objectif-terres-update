<?php

namespace App\Models;

use App\Models\Traits\Locationable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property int $code
 * @property string $alpha2
 * @property string $alpha3
 * @property string $name_en_gb
 * @property string $name_fr_fr
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereNameFrFr($value)
 * @mixin \Eloquent
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereAlpha2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereAlpha3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNameEnGb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 */
class Country extends Model
{

	/**a
	 * @var array
	 */
	protected $fillable = ['code', 'alpha2', 'alpha3', 'name_en_gb', 'name_fr_fr'];


}
