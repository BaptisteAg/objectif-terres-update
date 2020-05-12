<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SupportStage
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportStage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupportStage extends Model
{
	public const FIRST_CONTACT_ID = 1;
	public const FIRST_RECEPTION_ID = 2;
	public const ACCOMPANYING_ID = 3;

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
