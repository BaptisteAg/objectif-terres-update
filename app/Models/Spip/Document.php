<?php

namespace App\Models\Spip;

/**
 * App\Models\Spip\Document
 *
 * @property int $id_document
 * @property int $id_vignette
 * @property string $extension
 * @property string $titre
 * @property string $date
 * @property string $descriptif
 * @property string $fichier
 * @property int|null $taille
 * @property int|null $largeur
 * @property int|null $hauteur
 * @property int|null $duree
 * @property string $media
 * @property string $mode
 * @property string|null $distant
 * @property string $statut
 * @property string $credits
 * @property string $date_publication
 * @property int|null $brise
 * @property string $maj
 * @property string $composition
 * @property int $composition_lock
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereBrise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDatePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDescriptif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDistant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFichier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereHauteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIdDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIdVignette($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereLargeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTitre($value)
 *
 * @mixin \Eloquent
 */
class Document extends SpipModel
{
    protected $table = 'spip_documents';

    protected $primaryKey = 'id_document';
}
