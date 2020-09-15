<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CmsCommonContent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $pages_name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent wherePagesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCommonContent whereUpdatedAt($value)
 */
class CmsCommonContent extends Model
{
	use Documentable;
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
		'name', 'description',  'slug', 'pages_name', 'content', 'created_at', 'updated_at', "has_documents"
	];


}
