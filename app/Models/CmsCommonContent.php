<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CmsCommonContent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent query()
 * @mixin \Eloquent
 */
class CmsCommonContent extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'cms_common_contents';

	/**
	 * @var array
	 */
	protected $fillable = [
		'name', 'description',  'slug', 'pages_name', 'content', 'created_at', 'updated_at'
	];


}
