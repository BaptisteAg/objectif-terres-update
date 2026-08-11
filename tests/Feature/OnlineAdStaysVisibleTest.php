<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\BioCertification;
use App\Models\Department;
use App\Models\LandOfferAd;
use App\Models\OfferGenre;
use App\Models\ProductionGenre;
use App\Models\User;
use App\Services\AttributionAds\AttributionAdsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Une annonce validée et publiée ne doit jamais être dépubliée par une modification de son auteur·e.
 *
 * Historiquement, l'édition d'une annonce en ligne repassait is_draft à 1 (bouton « Enregistrer en
 * brouillon ») ou remettait le statut à « À modérer » (parcours « Demander la publication »).
 * Dans les deux cas AdsController@show renvoyait un 404 à tout le monde sauf au propriétaire et
 * aux modérateurs du territoire — c'est le bug du ticket Teamwork 36119239 (annonce 10908).
 */
class OnlineAdStaysVisibleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // attribution_ads.ad_status_id est contraint par une clé étrangère sur ad_statuses ;
        // les référentiels suivants sont requis par la validation du formulaire d'annonce.
        $this->seed(\AdStatusSeeder::class);
        $this->seed(\BioCertificationSeeder::class);
        $this->seed(\OfferGenreSeeder::class);

        Notification::fake();
    }

    /**
     * Une annonce en ligne est visible par un visiteur anonyme.
     */
    public function testOnlineAdIsPubliclyVisible(): void
    {
        $ad = $this->createOnlineAd();

        $this->get('/annonces/' . $ad->id)->assertStatus(200);
    }

    /**
     * Reproduction du bug : une annonce validée et publiée mais marquée brouillon renvoie un 404.
     */
    public function testPublishedAdMarkedAsDraftIsNotFound(): void
    {
        $ad = $this->createOnlineAd();
        $this->markAsDraft($ad);

        $this->get('/annonces/' . $ad->id)->assertStatus(404);
    }

    /**
     * Chemin A : « Enregistrer en brouillon » sur une annonce en ligne ne doit plus la dépublier.
     *
     * C'est le scénario exact de l'annonce 10908 : l'annonceur modifie son annonce publiée et
     * l'enregistre, ce qui la faisait basculer en brouillon donc en 404 pour tout le public.
     */
    public function testSavingAsDraftAnOnlineAdKeepsItOnline(): void
    {
        $ad = $this->createOnlineAd();

        $this->actingAs($ad->userPp)
            ->post('/annonces/sauvegarder', $this->adFormPayload($ad, 'Titre modifié'))
            ->assertRedirect(route('ads.show', ['id' => $ad->id]));

        $ad->refresh();

        $this->assertSame(0, (int)$ad->is_draft, "L'annonce ne doit pas repasser en brouillon.");
        $this->assertSame('Titre modifié', $ad->title);
        $this->assertSame(AdStatus::APPROVE_ID, $ad->attributionAd->ad_status_id);
        $this->assertNotNull($ad->attributionAd->pending_update_since);

        // Toujours visible du public pendant la re-modération.
        auth()->logout();
        $this->get('/annonces/' . $ad->id)->assertStatus(200);
    }

    /**
     * Un tiers ne peut pas modifier l'annonce d'un autre en postant son identifiant.
     */
    public function testAnotherUserCannotUpdateSomeoneElsesAd(): void
    {
        $ad = $this->createOnlineAd();
        $intruder = $this->createUser(0);

        $this->actingAs($intruder)
            ->post('/annonces/sauvegarder', $this->adFormPayload($ad, 'Titre pirate'))
            ->assertStatus(403);

        $this->assertSame('Annonce en ligne', $ad->refresh()->title);
    }

    /**
     * Chemin B : demander la publication d'une annonce déjà en ligne ne doit pas la dépublier.
     */
    public function testRequestPublishingOnOnlineAdKeepsItOnline(): void
    {
        $ad = $this->createOnlineAd();

        $this->actingAs($ad->userPp)
            ->get('/annonces/request-publishing/' . $ad->id)
            ->assertRedirect(route('ads.show', [$ad->id]));

        $ad->refresh();

        $this->assertSame(0, (int)$ad->is_draft);
        $this->assertSame(AdStatus::APPROVE_ID, $ad->attributionAd->ad_status_id);
        $this->assertNotNull($ad->attributionAd->published_on);
        $this->assertNotNull(
            $ad->attributionAd->pending_update_since,
            "L'annonce doit être signalée au modérateur comme modifiée après publication."
        );
    }

    /**
     * Le marqueur est levé lorsque le modérateur valide à nouveau l'annonce.
     */
    public function testAcceptingAnAdClearsThePendingUpdateMarker(): void
    {
        $ad = $this->createOnlineAd();

        $this->actingAs($ad->userPp);

        $ad->attributionAd->pending_update_since = Carbon::now();
        $ad->attributionAd->save();

        app(AttributionAdsService::class)
            ->acceptAd(['attribution_ad_id' => $ad->attributionAd->id]);

        $ad->refresh();

        $this->assertNull($ad->attributionAd->pending_update_since);
        $this->assertSame(0, (int)$ad->is_draft);
    }

    /**
     * Non-régression : un brouillon jamais publié reste invisible du public.
     */
    public function testNeverPublishedDraftStaysHidden(): void
    {
        $userPp = $this->createUser(0);

        auth()->login($userPp);

        $ad = Ad::create([
            'user_pp_id' => $userPp->id,
            'is_draft' => 1,
            'title' => 'Brouillon jamais publié',
            'about_content' => 'Contenu',
            'about_project_content' => 'Projet',
        ]);

        auth()->logout();

        $this->get('/annonces/' . $ad->id)->assertStatus(404);
    }

    /**
     * La commande de réparation ne modifie rien en dry-run, puis remet l'annonce en ligne.
     */
    public function testRepairCommandDryRunDoesNotChangeAnything(): void
    {
        $ad = $this->createOnlineAd();
        $this->markAsDraft($ad);

        $this->artisan('ads:repair-published-drafts', ['--dry-run' => true])
            ->assertExitCode(0);

        $ad->refresh();
        $this->assertSame(1, (int)$ad->is_draft);

        $this->artisan('ads:repair-published-drafts')->assertExitCode(0);

        $ad->refresh();
        $this->assertSame(0, (int)$ad->is_draft);
        $this->get('/annonces/' . $ad->id)->assertStatus(200);
    }

    /**
     * Reproduit l'état corrompu : annonce validée et publiée, mais marquée brouillon.
     */
    private function markAsDraft(Ad $ad): void
    {
        // L'observateur d'historique exige un utilisateur authentifié à l'écriture.
        auth()->login($ad->userPp);

        $ad->is_draft = 1;
        $ad->save();

        auth()->logout();
    }

    /**
     * Crée une annonce validée, publiée et visible du public.
     */
    private function createOnlineAd(): Ad
    {
        $userPp = $this->createUser(0);
        $moderator = $this->createUser(1);

        auth()->login($userPp);

        $ad = Ad::create([
            'user_pp_id' => $userPp->id,
            'is_draft' => 0,
            'title' => 'Annonce en ligne',
            'about_content' => 'Contenu',
            'about_project_content' => 'Projet',
            // La page de détail affiche le département principal de l'annonce.
            'department_id' => Department::query()->firstOrFail()->id,
        ]);

        // Le type d'une annonce est déduit de la présence d'une ligne fille (Ad::getTypeAttribute).
        LandOfferAd::create([
            'ad_id' => $ad->id,
            'surface' => 12,
            'accept_use_zip_code' => 1,
        ]);

        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $moderator->id,
            'ad_status_id' => AdStatus::APPROVE_ID,
            'published_on' => Carbon::now()->subDay(),
        ]);

        auth()->logout();

        return $ad->refresh();
    }

    /**
     * Payload minimal accepté par AdRequest pour une offre de foncier.
     */
    private function adFormPayload(Ad $ad, string $title): array
    {
        return [
            'id' => $ad->id,
            'ad_type' => 'land_offer',
            'ad_contact_type' => 'me',
            'title' => $title,
            'about_content' => 'Contenu',
            'about_project_content' => 'Projet',
            'department_id' => $ad->department_id,
            'locationable' => ['departments' => [$ad->department_id]],
            'land_offer' => [
                'production_genres' => [ProductionGenre::query()->firstOrFail()->id],
                'bio_certifications' => [BioCertification::query()->firstOrFail()->id],
                'offer_genres' => [OfferGenre::query()->firstOrFail()->id],
                'surface' => 12,
                'water_access' => 0,
                'has_buildings' => 0,
                'has_houses' => 0,
                'price' => 1000,
            ],
        ];
    }

    private function createUser(int $role): User
    {
        return User::create([
            'name' => 'Test',
            'first_name' => 'Role' . $role,
            'email' => uniqid('user-', false) . '@example.test',
            'password' => bcrypt('secret'),
            'role' => $role,
        ]);
    }
}
