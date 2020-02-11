<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Requirement
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Requirement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Requirement extends Model
{
    //
}
