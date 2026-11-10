<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CmsFaq
 *
 * @property int $id
 * @property string $page_name
 * @property string $content_question
 * @property string $content_answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq whereContentAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq whereContentQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq wherePageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFaq whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CmsFaq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_faq';

    protected $fillable = [
        'id',
        'page_name',
        'content_question',
        'content_answer',
        'created_at',
        'updated_at',
    ];

    public static $page_name = [
        'home',
        'transmettre-ma-ferme',
        'confier-mes-terres',
        'trouver-une-terre-ou-des-financements',
        'trouver-un-emploi',
    ];
}
