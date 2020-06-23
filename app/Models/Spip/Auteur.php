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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereAleaActuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereAleaFutur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCadresse2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCadresse3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCookieOubli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCpnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereCtel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereEnLigne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereHtpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereIdAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereImessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereLowSec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereMessagerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereNomSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur wherePgp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur wherePrefs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereUrlSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Auteur whereWebmestre($value)
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
