<?php

namespace App\Models\Spip;


/**
 * App\Models\Spip\Auteur
 *
 * @property int $id_auteur
 * @property string $nom
 * @property string $bio
 * @property string $email
 * @property string $nom_site
 * @property string $url_site
 * @property string|null $login
 * @property string $pass
 * @property string $low_sec
 * @property string $statut
 * @property string $webmestre
 * @property string $maj
 * @property string $pgp
 * @property string $htpass
 * @property string $en_ligne
 * @property string|null $alea_actuel
 * @property string|null $alea_futur
 * @property string|null $prefs
 * @property string|null $cookie_oubli
 * @property string $source
 * @property string $lang
 * @property string|null $imessage
 * @property string|null $messagerie
 * @property string $composition
 * @property int $composition_lock
 * @property string $cadresse2
 * @property string $cadresse3
 * @property string $cp
 * @property string $ville
 * @property string $cnom
 * @property string $cpnom
 * @property string $cadresse
 * @property string $ctel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAleaActuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAleaFutur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCadresse2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCadresse3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCookieOubli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCpnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCtel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereEnLigne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereHtpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereIdAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereImessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereLowSec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereMessagerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereNomSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur wherePgp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur wherePrefs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereUrlSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereWebmestre($value)
 * @mixin \Eloquent
 */
class Auteur extends SpipModel
{
    protected $table = "spip_auteurs";
    protected $primaryKey = "id_auteur";

    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(
            Article::class,
            'spip_auteurs_liens',
            'id_auteur',
            'id_objet'
        )
            ->where('id_rubrique', '30')
            ->where('id_secteur', '4')
            ->where('statut', '<>', 'refuse')
            ->where('objet', 'article');
    }
}
