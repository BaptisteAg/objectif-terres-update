<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\CmsPage
 *
 * @property int $id
 * @property string $page_name
 * @property string $slug
 * @property string $description
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $has_documents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereHasDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage wherePageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsPage extends Model
{
	use Documentable;


	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'cms_pages';

	/**
	 * @var array
	 */
	protected $fillable = [
		'page_name', 'description', 'slug', 'content', 'created_at', 'updated_at', 'has_documents'
	];

	static $editable_pages = [
		'bandeau-de-participation' => 'Bandeau de participation',
		'/ ' => 'Page d\'accueil',
		'qui-sommes-nous' => 'Qui sommes-nous?',
		'transmettre-ma-ferme' => 'Transmettre ma ferme',
		'confier-mes-terres' => 'Confier mes terres',
		'louer-vendre-mes-terres' => 'Louer ou vendre mes terres',
		'minstaller-comme-paysan' => 'M’installer comme paysan',
		'ressources-utiles' => 'Ressources utiles',
		'trouver-un-emploi' => 'Trouver un emploi',
		'contactez-nous' => 'Contactez-nous',
		'annonces/creer' => 'Publier une annonce',
		'accompagnement/démarrer' => 'Être accompagné',
		'mentions-legales' => 'Mentions légales'
	];

	/**
	 * Create the slug from the title
	 */
	public function setSlugAttribute()
	{
		// grab the title and slugify it for seeds
		if (! is_null($this->description) && $this->description!=="") {
			return $this->attributes['slug'] = Str::slug($this->page_name) . '-' . Str::slug($this->description);
		}
		return $this->attributes['slug'] = Str::slug($this->page_name);

	}
}
