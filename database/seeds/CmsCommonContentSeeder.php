<?php

use App\Models\CmsCommonContent;
use App\Models\Territory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory;


class CmsCommonContentSeeder extends Seeder
{
	public function run()
	{
		$faker = Factory::create('fr_FR');
		CmsCommonContent::insert([
			[
				'name' => 'Description vidéo',
				"description" => 'Texte de description afficher au dessus de la vidéo',
				'pages_name' => 'transmettre-ma-ferme, confier-mes-terres, minstaller-comme-paysan ',
				'slug' => 'text-video',
				'content' => '<span>' . $faker->sentence() . '</span>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => 'Téléchargement guide',
				"description" => 'Texte de description pour le téléchargement du guide',
				'pages_name' => 'transmettre-ma-ferme, confier-mes-terres, trouver-une-terre-ou-des-financements, minstaller-comme-paysan, ressources-utiles, trouver-un-emploi',
				'slug' => 'text-telechargement-guide',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 1
			],
			[
				'name' => '"Par où démarrer"',
				"description" => 'Texte de d\'introduction',
				'slug' => 'par-ou-commencer-introduction',
				'pages_name' => 'transmettre-ma-ferme, trouver-une-terre-ou-des-financements, minstaller-comme-paysan, trouver-un-emploi',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => '"Par où démarrer"',
				"description" => 'Texte première étape',
				'pages_name' => 'transmettre-ma-ferme, trouver-une-terre-ou-des-financements, minstaller-comme-paysan, trouver-un-emploi',
				'slug' => 'par-ou-commencer-premiere-etape',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => '"Par où démarrer"',
				"description" => 'Texte deuxième étape',
				'pages_name' => 'transmettre-ma-ferme, trouver-une-terre-ou-des-financements, minstaller-comme-paysan, trouver-un-emploi',
				'slug' => 'par-ou-commencer-deuxieme-etape',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			], [
				'name' => '"Par où démarrer"',
				"description" => 'Texte troisième étape',
				'pages_name' => 'transmettre-ma-ferme, trouver-une-terre-ou-des-financements, minstaller-comme-paysan, trouver-un-emploi',
				'slug' => 'par-ou-commencer-troisieme-etape',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => '"Donner-vous plus de chances"',
				"description" => 'Texte description',
				'pages_name' => 'trouver-une-terre-ou-des-financements, minstaller-comme-paysan',
				'slug' => 'donnez-vous-plus-de-chance',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => 'Chiffres clés',
				"description" => 'Texte description',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'chiffre-description',
				'content' => '<h2>Titre Section</h2><p>' . $faker->paragraphs(2, true) . '</p>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			], [
				'name' => 'Chiffres clés',
				"description" => 'Premier chiffre',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'premier-chiffre',
				'content' =>  $faker->numberBetween(0, 100) ,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			], [
				'name' => 'Chiffres clés',
				"description" => 'Texte premier chiffre',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'description-premier-chiffre',
				'content' => '<span>' . $faker->sentence() . '</span>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			], [
				'name' => 'Chiffres clés',
				"description" => 'Deuxième chiffre',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'deuxieme-chiffre',
				'content' =>  $faker->numberBetween(0, 100) ,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => 'Chiffres clés',
				"description" => 'Texte deuxième chiffre',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'description-deuxieme-chiffre',
				'content' => '<span>' . $faker->sentence() . '</span>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => 'Chiffres clés',
				"description" => 'Troisème chiffre',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'troisieme-chiffre',
				'content' =>  $faker->numberBetween(0, 100) ,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
			[
				'name' => 'Chiffres clés',
				"description" => 'Texte troisième description',
				'pages_name' => 'trouver-une-terre-ou-des-financements, trouver-un-emploi',
				'slug' => 'description-troisieme-chiffre',
				'content' => '<span>' . $faker->sentence() . '</span>',
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'has_documents' => 0
			],
		]);
	}
}
