<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyAdUser extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

}