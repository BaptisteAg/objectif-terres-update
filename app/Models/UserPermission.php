<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPermission
 *
 * @property int $id
 * @property int $user_id
 * @property int $permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPermission whereUserId($value)
 * @mixin \Eloquent
 */
class UserPermission extends Model
{


	protected $fillable = ['user_id', 'permission'];

	static $permissions = [
		1 => "Utilisateurs peut être choisis dans le processus d'attribution d'un modérateur",
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
