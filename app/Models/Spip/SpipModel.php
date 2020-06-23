<?php

namespace App\Models\Spip;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Spip\SpipModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\SpipModel query()
 * @mixin \Eloquent
 */
class SpipModel extends Model
{
    protected $connection = 'mysql_spip';
}
