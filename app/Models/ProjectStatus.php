<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectStatus extends Model
{
	public const EMERGING_ID = 1;
	public const IN_PROGRESSING_ID = 2;
	public const ABANDONED_ID = 3;
	public const ACCOMPLISHED_ID = 4;

	public const TOOLTIPS = [
		self::EMERGING_ID => "En émergence = projet au stade des premières idées/réflexions ",
		self::IN_PROGRESSING_ID => "En cours = projet abouti en phase opérationnelle (recherche de terres, de candidats, etc.) ",
		self::ABANDONED_ID => "Abandonné = projet d’installation ou de transmission finalement avorté ",
		self::ACCOMPLISHED_ID => "Abouti = l’installation ou la transmission est effective !"
	];

	/**
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function researches()
	{
		return $this->belongsToMany(Research::class)->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function projects()
	{
		return $this->hasMany(Project::class);
	}
}
