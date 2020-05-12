<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AdNote
 *
 * @property int $id
 * @property string $value
 * @property int $user_id
 * @property string|null $contact_name
 * @property int $ad_id
 * @property int $project_data_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUserId($value)
 * @mixin \Eloquent
 */
class AdNote extends Model
{
	use Documentable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'ad_id', 'value', 'user_id', 'contact_name', 'project_data_key_id'
	];

	/**
	 * @return BelongsTo
	 */
	public function ad()
	{
		return $this->belongsTo(Ad::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function projectDataKey()
	{
		return $this->belongsTo(ProjectDataKey::class);
	}


}
