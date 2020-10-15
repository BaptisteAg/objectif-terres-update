<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Newsletter
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter query()
 * @mixin \Eloquent
 */
class Newsletter extends Model
{
    protected $table = "newsletter";

    protected $fillable = ["email"];
}
