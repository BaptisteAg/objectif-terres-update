<?php

namespace App\Models\Spip;

/**
 * App\Models\Spip\Mot
 *
 * @property int $id_mot
 * @property string $titre
 * @property string $descriptif
 * @property string $texte
 * @property int $id_groupe
 * @property string $type
 * @property string $maj
 * @property string $composition
 * @property int $composition_lock
 * @property string $carte
 * @property string $carte_mini
 * @property string $abr
 * @property string $carte_bas
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Mot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereAbr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereCarte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereCarteBas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereCarteMini($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereComposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereCompositionLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereDescriptif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereIdGroupe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereIdMot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereMaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereTexte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mot whereType($value)
 *
 * @mixin \Eloquent
 */
class Mot extends SpipModel
{
    protected $table = 'spip_mots';

    protected $primaryKey = 'id_mot';
}
