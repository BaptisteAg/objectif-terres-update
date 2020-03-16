<?php

use App\Models\Ad;
use App\Models\AdNote;
use App\Models\BioCertification;
use App\Models\Document;
use App\Models\FavoriteAd;
use App\Models\JobOfferAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\Project;
use App\Models\ProductionGenre;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function run()
	{
		$queriesCount = 0;
		DB::listen(function ($query) use (&$queriesCount) {
			echo "\n$query->sql";
			$queriesCount++;
		});

		DB::transaction(function () use (&$queriesCount) {
			\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__ . '/../sql/countries.sql'));
			\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__ . '/../sql/regions.sql'));
			\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__ . '/../sql/departments.sql'));
			\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__ . '/../sql/cities.sql'));


			$this->call([
				RequirementSeeder::class,
				BuildingTypeSeeder::class,
				PriceRangeSeeder::class,
				SurfaceRangeSeeder::class,
				InstallationTypeSeeder::class,
				ProductionGenreSeeder::class,
				BioCertificationSeeder::class,
				JobOfferTypeSeeder::class,
				OfferGenreSeeder::class,
				ProjectStatusSeeder::class,
				ProjectSeeder::class,
				AdStatusSeeder::class,
				EducationLevelSeeder::class,
			]);


			if (app()->environment() === "local") {
				$this->call([
					TestUserSeeder::class,
					TestResponseTypeSeeder::class,
					TestResearchSeeder::class,
					TestResponseTemplateSeeder::class,
				]);

				$projectIds = Project::all()->pluck('id')->toArray();
				factory(Ad::class, 30)->create()->each(function (Ad $ad) use (&$queriesCount, &$projectIds) {
					$ad->adNotes()->save(factory(AdNote::class)->make());
					$ad->favoriteAds()->save(factory(FavoriteAd::class)->make());
//					$ad->documents()->save(factory(Document::class)->make());
					$ad->regions()->save(Region::inRandomOrder()->first());
					if ($ad->attributionAd->adStatus->id === 1) {
						$ad->project_id = array_shift($projectIds);
						$ad->save();
					}
					echo "\nAd ID saved : " . $ad->id . " (Queries : " . $queriesCount . ")";
				});
				$adIds = Ad::all()->pluck("id")->toArray();
				factory(LandOfferAd::class, 10)->create()->each(function (LandOfferAd $landOfferAd) use (&$adIds) {

					$cats = ['', 'Vend'];
					$types = ['ferme', 'pâture', 'terrain', 'location', 'terre', 'petite structure'];
					$pours = ['petit élevage', 'élevage caprins', 'élevage ovins', 'élevages poulets', 'réinstallation', 'installation collective'];
					$extra = ['', 'urgent', 'avec ou sans habitation', 'avec parcelle constructible'];

					$landOfferAd->bioCertifications()->save(BioCertification::inRandomOrder()->first());
					$landOfferAd->productionGenres()->save(ProductionGenre::inRandomOrder()->first());
					$landOfferAd->ad_id = array_shift($adIds);
					$landOfferAd->save();
					$ad = Ad::find($landOfferAd->ad_id);
					$ad->title = trim(
						$cats[array_rand($cats)] . ' ' .
						$types[array_rand($types)] . ' pour ' .
						$pours[array_rand($pours)] . ' ' .
						$extra[array_rand($extra)]
					);
					$ad->save();
				});
				factory(LandSeekAd::class, 10)->create()->each(function (LandSeekAd $landSeekAd) use (&$adIds) {
					$cats = ['', 'Recherche', 'A la recherche de'];
					$types = ['ferme', 'pâture', 'terrain', 'location', 'terre', 'petite structure'];
					$pours = ['petit élevage', 'élevage caprins', 'élevage ovins', 'élevages poulets', 'réinstallation', 'installation collective'];
					$extra = ['', 'urgent', 'avec ou sans habitation', 'avec parcelle constructible'];

					//$landSeekAd->surfaceRanges()->save(SurfaceRange::inRandomOrder()->first());
					//$landSeekAd->priceRanges()->save(PriceRange::inRandomOrder()->first());
					$landSeekAd->ad_id = array_shift($adIds);
					$landSeekAd->save();
					$ad = Ad::find($landSeekAd->ad_id);
					$ad->title = trim(
						$cats[array_rand($cats)] . ' ' .
						$types[array_rand($types)] . ' pour ' .
						$pours[array_rand($pours)] . ' ' .
						$extra[array_rand($extra)]
					);
					$ad->save();

				});
				factory(JobOfferAd::class, 10)->create()->each(function (JobOfferAd $jobAd) use (&$adIds) {
					$cats = ['', 'Propose emploi', 'Recrutement', 'Urgent cherche', 'Opportunité'];
					$types = ['éleveur', 'producteur', 'agent agricole', 'agriculteur'];
					$pours = ['bio', 'laitier', 'élevage bovins', 'élevages poulets', 'réinstallation', 'installation collective'];
					$extra = ['', 'urgent', 'temps plein', 'CDI', 'CDD'];


					//$jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
					$jobAd->ad_id = array_shift($adIds);
					$jobAd->save();
					$ad = Ad::find($jobAd->ad_id);
					$ad->title = trim(
						$cats[array_rand($cats)] . ' ' .
						$types[array_rand($types)] . ' pour ' .
						$pours[array_rand($pours)] . ' ' .
						$extra[array_rand($extra)]
					);
					$ad->save();
				});
			}

		});


		echo "\nTotal queries : " . $queriesCount . "\n";
	}
}
