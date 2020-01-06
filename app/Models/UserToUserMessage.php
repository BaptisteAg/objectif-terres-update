<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $sf_user_id
 * @property string $content
 */
class UserToUserMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'sf_user_id', 'content'
    ];

}
