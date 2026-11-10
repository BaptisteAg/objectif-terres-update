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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Spip\Mot[] $mots
 * @property-read int|null $mots_count
 * @property-read \App\Models\Spip\Url|null $url
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAccepterForum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAccepterNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereActivite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamplibre1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamplibre2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamplibre3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamptitre1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamptitre2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChamptitre3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereChapo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContexte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtadresse2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtadresse3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtfax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtnom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCtprenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCttel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDateModif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDateRedac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescriptif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereEngagement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereEquipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFcout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFermePres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFermePresf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFinanceur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFlocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFpartenaires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFpatrimoine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFproductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereGfa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereHistoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIdArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIdRubrique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIdSecteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIdTrad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereLangueChoisie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereMailModerateur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereNomSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePartenaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePermanence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePopularite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePorteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePorteurtitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereProjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereReferers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereRencontre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereResumetitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSoustitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSurtitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTexte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUrlSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereVisites($value)
 *
 * @mixin \Eloquent
 */
class Article extends SpipModel
{
    protected $table = 'spip_articles';

    protected $primaryKey = 'id_article';

    public function auteurs()
    {
        return $this->belongsToMany(
            Auteur::class,
            'spip_auteurs_liens',
            'id_objet',
            'id_auteur'
        )->where('objet', 'article');
    }

    public function mots()
    {
        return $this->belongsToMany(
            Mot::class,
            'spip_mots_liens',
            'id_objet',
            'id_mot'
        )->where('objet', 'article');
    }

    public function documents()
    {
        return $this->belongsToMany(
            Document::class,
            'spip_documents_liens',
            'id_objet',
            'id_document'
        )->where('objet', 'article');
    }

    public function url()
    {
        return $this->hasOne(Url::class, 'id_objet', 'id_article')
            ->where('type', 'article');
    }
}
