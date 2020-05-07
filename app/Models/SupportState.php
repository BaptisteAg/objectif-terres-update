<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SupportState
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportState whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupportState extends Model
{
	public const TO_HANDLE_ID = 1;
	public const HANDLE_ID = 2;
	public const PENDING_ID = 3;
	public const ARCHIVE_ID = 4;

	/**
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function projects()
	{
		return $this->hasMany(Project::class);
	}
}
