<?php

use App\Models\CmsPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;


class CmsPageSeeder extends Seeder
{

	public function run()
	{
		CmsPage::insert([
			[
				'page_name' => 'Bandeau de participation',
				"description" => 'Soutenir Terre de Liens c’est préserver notre avenir',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

			],
			[
				'page_name' => 'Page d\'accueil',
				"description" => 'Mon projet agricole',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Page d\'accueil',
				"description" => 'Questions fréquentes',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Qui sommes-nous?',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Qui sommes-nous?',
				"description" => 'Les deux textes situés sous la bannière',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Qui sommes-nous?',
				"description" => 'En savoir plus sur l’association  Terre de Liens',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => '“Votre ferme continuera … un projet solide”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => 'Le texte au dessus de la vidéo',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => 'Questions fréquentes',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => '“Trouver le candidat idéal... de cession.”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Céder ma Ferme',
				"description" => '“Par où démarrer”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Confier mes terres',
				"description" => '“Partager son patrimoine… de don”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Confier mes terres',
				"description" => 'Le texte au dessus de la vidéo',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Confier mes terres',
				"description" => 'Questions fréquentes',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Confier mes terres',
				"description" => '“Léguez vos terres… par étape”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Confier mes terres',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],

			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => 'Texte d’introduction sous le titre principal et “vos terres vont nourrir… d’envergure”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => 'Questions fréquentes',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => '“Donnez vous plus de chances”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => 'Chiffres',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => '“Des projets partout en France”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Louer ou vendre mes terres',
				"description" => '“Par où démarrer”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => '“Votre projet d’installations”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => '“Donnez vous plus de chances”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => 'Chiffres',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => 'Les deux textes sous les chiffres',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'M’installer comme paysan',
				"description" => '“Par où démarrer”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Réussir son projet agricole”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Comment s’installer comme paysan ?”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Comment transmettre sa ferme ?”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Conseils juridique… fonciers”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Allier agriculture et biodiversité”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Ressources utiles',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Contactez-nous',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => 'Texte d’introduction sous le titre principal et “Votre plateforme… agricole”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => 'Texte sous le bloc d’images',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => 'Chiffres',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => 'Questions fréquentes',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => '“Avez-vous besoin d’un conseil… d’emploi ?”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => '“Téléchargez notre guide...”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => '“Avez-vous besoin d’un conseil… d’emploi ?”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Trouver un emploi',
				"description" => '“Par où démarrer”',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Publier une annonce',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			], [
				'page_name' => 'Être accompagné',
				"description" => 'Texte d’introduction sous le titre principal',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			], [
				'page_name' => 'Mentions légales',
				"description" => 'Toutes les mentions légales',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]
		]);
		$pages = CmsPage::all();
		foreach ($pages as $page){
			$page->setSlugAttribute();
			$page->save();
		}
	}
}
