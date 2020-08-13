<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPage extends Model
{
	public static function boot()
	{
		parent::boot();

// grab the title and description and slugify it
		static::saving(function ($cmsPage) {
			$cmsPage->slug = Str::slug($cmsPage->page_name) . '-' . Str::slug($cmsPage->description);
		});
	}

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
		'page_name', 'description', 'slug', 'content', 'created_at', 'updated_at'
	];

	static $editable_pages = [
		'bandeau-de-participation'=>'Bandeau de participation',
		'/ '=> 'Page d\'accueil',
		'qui-sommes-nous' =>'Qui sommes-nous?',
		'ceder-ma-ferme' =>'Céder ma Ferme',
		'confier-mes-terres' =>'Confier mes terres',
		'louer-vendre-mes-terres' =>'Louer ou vendre mes terres',
		'minstaller-comme-paysan' =>'M’installer comme paysan',
		'ressources-utiles' =>'Ressources utiles',
		'trouver-un-emploi' =>'Trouver un emploi',
		'contactez-nous' =>'Contactez-nous',
		'annonces/creer' =>'Publier une annonce',
		'accompagnement/démarrer' =>'Être accompagné',
		'mentions-legales' =>'Mentions légales'

	];
}
