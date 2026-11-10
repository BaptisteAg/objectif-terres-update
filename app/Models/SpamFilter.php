<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpamFilter
 *
 * @property int $id
 * @property string $type (email|pattern)
 * @property string $value
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SpamFilter extends Model
{
    const TYPE_EMAIL = 'email';

    const TYPE_PATTERN = 'pattern';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'value',
        'description',
        'is_active',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active filters.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only email filters.
     */
    public function scopeEmails($query)
    {
        return $query->where('type', self::TYPE_EMAIL);
    }

    /**
     * Scope to get only pattern filters.
     */
    public function scopePatterns($query)
    {
        return $query->where('type', self::TYPE_PATTERN);
    }

    /**
     * Get all active blacklisted emails.
     */
    public static function getActiveEmails(): array
    {
        return self::active()->emails()->pluck('value')->toArray();
    }

    /**
     * Get all active spam patterns.
     */
    public static function getActivePatterns(): array
    {
        return self::active()->patterns()->pluck('value')->toArray();
    }
}
