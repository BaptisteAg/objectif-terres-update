<?php

namespace App\Models\Spip;


/**
 * App\Models\Spip\Article
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article query()
 * @mixin \Eloquent
 */
class Article extends SpipModel
{
    protected $table = "spip_articles";
    protected $primaryKey = "id_article";

    public function auteurs()
    {
        return $this->belongsToMany(
            Auteur::class,
            'spip_auteurs_liens',
            'id_objet',
            'id_auteur'
        )->where('objet', 'article');
    }
}
