<?php

namespace App\Models\Spip;


/**
 * App\Models\Spip\Url
 *
 * @property int $id_parent
 * @property int $url
 * @property string $type
 * @property int $id_objet
 * @property string $date
 * @property int $segments
 * @property int $perma
 * @property string $langue
 * @method static \Illuminate\Database\Eloquent\Builder|Url newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Url newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Url query()
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereIdObjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereLangue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url wherePerma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereSegments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Url whereUrl($value)
 * @mixin \Eloquent
 */
class Url extends SpipModel
{
    protected $table = "spip_urls";
    protected $primaryKey = "url";
    public $incrementing = false;
    protected $keyType = 'string';
}
