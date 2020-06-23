<?php

namespace App\Models\Spip;


/**
 * App\Models\Spip\Article
 *
 * @property int $id_article
 * @property string $surtitre
 * @property string $titre
 * @property string $soustitre
 * @property int $id_rubrique
 * @property string $descriptif
 * @property string $chapo
 * @property string $texte
 * @property string $ps
 * @property string $date
 * @property string $statut
 * @property int $id_secteur
 * @property string $maj
 * @property string|null $export
 * @property string $date_redac
 * @property int $visites
 * @property int $referers
 * @property float $popularite
 * @property string $accepter_forum
 * @property string $date_modif
 * @property string $lang
 * @property string|null $langue_choisie
 * @property int $id_trad
 * @property string $nom_site
 * @property string $url_site
 * @property string $virtuel
 * @property string $composition
 * @property int $composition_lock
 * @property string $accepter_note
 * @property string $ctadresse2
 * @property string $ctadresse3
 * @property string $cp
 * @property string $ville
 * @property string $porteurtitre
 * @property string $resumetitre
 * @property string $ferme_presf
 * @property string $ferme_pres
 * @property string $fpatrimoine
 * @property string $fproductions
 * @property string $fpartenaires
 * @property string $fcout
 * @property string $prix
 * @property string $ctnom
 * @property string $ctprenom
 * @property string $ctemail
 * @property string $ctadresse
 * @property string $cttel
 * @property string $ctfax
 * @property string $mail_moderateur
 * @property string $flocalisation
 * @property string $region
 * @property string $permanence
 * @property string $histoire
 * @property string $activite
 * @property string $contexte
 * @property string $equipe
 * @property string $partenaire
 * @property string $financeur
 * @property string $rencontre
 * @property string $engagement
 * @property string $porteur
 * @property string $info
 * @property string $gfa
 * @property string $projet
 * @property string $champlibre1
 * @property string $champlibre2
 * @property string $champlibre3
 * @property string $champtitre1
 * @property string $champtitre2
 * @property string $champtitre3
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereAccepterForum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereAccepterNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereActivite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamplibre1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamplibre2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamplibre3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamptitre1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamptitre2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChamptitre3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereChapo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereContexte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtadresse2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtadresse3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtfax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCtprenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereCttel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereDateModif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereDateRedac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereDescriptif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereEngagement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereEquipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFcout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFermePres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFermePresf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFinanceur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFlocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFpartenaires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFpatrimoine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereFproductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereGfa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereHistoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereIdArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereIdRubrique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereIdSecteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereIdTrad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereLangueChoisie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereMailModerateur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereNomSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePartenaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePermanence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePopularite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePorteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePorteurtitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereProjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article wherePs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereReferers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereRencontre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereResumetitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereSoustitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereSurtitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereTexte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereUrlSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Spip\Article whereVisites($value)
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
