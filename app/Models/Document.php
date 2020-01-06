<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $path
 * @property string $type_document
 */
class Document extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'path', 'type_document'
    ];

    /**
     * Get all of the ads who have documents.
     *
     * @return MorphToMany
     */
    public function ads()
    {
        return $this->morphedByMany('App\Models\Research', 'documentable');
    }

    /**
     * Get all of the ad_notes who have documents.
     *
     * @return MorphToMany
     */
    public function adNotes()
    {
        return $this->morphedByMany('App\Models\AdNote', 'documentable');
    }
}
