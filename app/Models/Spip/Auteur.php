<?php

namespace App\Models\Spip;


/**
 * App\Models\Spip\Auteur
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur query()
 * @mixin \Eloquent
 */
class Auteur extends SpipModel
{
    protected $table = "spip_auteurs";
    protected $primaryKey = "id_auteur";

    public function articles()
    {
        return $this->belongsToMany(
            Article::class,
            'spip_auteurs_liens',
            'id_auteur',
            'id_objet'
        )->where('objet', 'article');
    }
}
