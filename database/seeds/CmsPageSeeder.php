<?php

use App\Models\CmsPage;
use App\Models\Territory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory;


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
				"description" => '“Trouver le candidat idéal... de cession.”',
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
				"description" => '“Léguez vos terres… par étape”',
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
				"description" => '“Donnez vous plus de chances”',
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
				"description" => 'Les deux textes sous les chiffres',
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
				"description" => '“Avez-vous besoin d’un conseil… d’emploi ?”',
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
			],
			[
				'page_name' => 'Aide et Ressoures',
				"description" => 'Responsable Territorial-Text d\'introduction',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],
			[
				'page_name' => 'Aide et Ressoures',
				"description" => 'Responsable Territorial-Conseiller un primo-accueillant',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			], [
				'page_name' => 'Aide et Ressoures',
				"description" => 'Primo-accueillant-Text d\'introduction',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			], [
				'page_name' => 'Aide et Ressoures',
				"description" => 'Modérateur-Text d\'introduction',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			],


		]);
		$pages = CmsPage::all();
		foreach ($pages as $page) {
			$page->setSlugAttribute();
			$faker = Factory::create('fr_FR');
			$page->content = '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>';
			$page->save();
		}

		$territories = Territory::all();
		foreach ($territories as $territory) {
			CmsPage::insert([
				'page_name' => 'Être accompagné',
				'description' => 'Text du territoire ' . $territory->name,
				'slug' => "etre-accompagne-text-du-territoire-numero-".$territory->id,
				'content' => "L’association TDL " . $territory->name . " fonctionne grâce à la mobilisation de citoyennes et citoyens bénévoles organisé·e·s en groupes locaux. Chaque groupe s’organise de façon autonome pour mener ses actions sur son territoire, notamment l’accueil, l’orientation et l’accompagnement des porteurs de projets. Leurs capacités pour accompagner les porteur.se.s de projet dans leur recherche de foncier peuvent être limitées, la plupart d’entre eux étant actuellement mobilisés sur des projets d’acquisition Terre de Liens. ",
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]);
		}


	}
}
