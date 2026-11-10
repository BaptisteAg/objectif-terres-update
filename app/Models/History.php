<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\History
 *
 * @property int $id
 * @property string $reference_table
 * @property int $reference_id
 * @property int $ad_id
 * @property int $actor_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 * @method static \Illuminate\Database\Eloquent\Builder|History whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereReferenceTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class History extends Model
{
    protected $table = 'histories';

    /**
     * @var array
     */
    protected $fillable = [
        'reference_table',
        'reference_id',
        'ad_id',
        'actor_id',
        'body',
        'created_at',
        'updated_at',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d/m/Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d/m/Y');
    }
}
