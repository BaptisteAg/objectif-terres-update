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
use Database\Seeders\AdStatusSeeder;
use Database\Seeders\BioCertificationSeeder;
use Database\Seeders\OfferGenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Comportement de l'édition d'une annonce déjà en ligne (ticket Teamwork 36119239, annonce 10908).
 *
 * Le bug d'origine : l'édition faisait disparaître l'annonce définitivement, sans recours pour
 * l'annonceur (is_draft repassé à 1, ou statut « À modérer » sans retour possible).
 *
 * Le comportement voulu par Terre de Liens (principe de précaution) : modifier une annonce en ligne
 * la renvoie en modération ET la masque du public jusqu'à re-validation ; la re-validation par le
 * modérateur la remet en ligne. Un vrai brouillon jamais publié reste, lui, masqué et soumettable.
 */
class OnlineAdEditModerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // attribution_ads.ad_status_id est contraint par une clé étrangère sur ad_statuses ;
        // les référentiels suivants sont requis par la validation du formulaire d'annonce.
        $this->seed(AdStatusSeeder::class);
        $this->seed(BioCertificationSeeder::class);
        $this->seed(OfferGenreSeeder::class);

        Notification::fake();
    }

    /**
     * Une annonce en ligne est visible par un visiteur anonyme.
     */
    public function test_online_ad_is_publicly_visible(): void
    {
        $ad = $this->createOnlineAd();

        $this->get('/annonces/'.$ad->id)->assertStatus(200);
    }

    /**
     * Reproduction du bug : une annonce validée et publiée mais marquée brouillon renvoie un 404.
     */
    public function test_published_ad_marked_as_draft_is_not_found(): void
    {
        $ad = $this->createOnlineAd();
        $this->markAsDraft($ad);

        $this->get('/annonces/'.$ad->id)->assertStatus(404);
    }

    /**
     * Édition d'une annonce en ligne : elle repart en modération ET disparaît du public
     * (principe de précaution demandé par Terre de Liens), au lieu de rester visible.
     */
    public function test_editing_an_online_ad_sends_it_back_to_moderation_and_hides_it(): void
    {
        $ad = $this->createOnlineAd();

        $this->actingAs($ad->userPp)
            ->post('/annonces/sauvegarder', $this->adFormPayload($ad, 'Titre modifié'))
            ->assertRedirect(route('ads.show', ['id' => $ad->id]));

        $ad->refresh();

        $this->assertSame('Titre modifié', $ad->title);
        $this->assertSame(0, (int) $ad->is_draft, "L'annonce n'est pas un brouillon, mais en re-modération.");
        $this->assertSame(
            AdStatus::PENDING_MODERATION_STATUS_ID,
            $ad->attributionAd->ad_status_id,
            "L'annonce doit repasser en « À modérer »."
        );
        $this->assertNotNull($ad->attributionAd->pending_update_since);

        // Masquée du public tant qu'elle n'est pas revalidée.
        auth()->logout();
        $this->get('/annonces/'.$ad->id)->assertStatus(404);
    }

    /**
     * Un tiers ne peut pas modifier l'annonce d'un autre en postant son identifiant.
     */
    public function test_another_user_cannot_update_someone_elses_ad(): void
    {
        $ad = $this->createOnlineAd();
        $intruder = $this->createUser(0);

        $this->actingAs($intruder)
            ->post('/annonces/sauvegarder', $this->adFormPayload($ad, 'Titre pirate'))
            ->assertStatus(403);

        $this->assertSame('Annonce en ligne', $ad->refresh()->title);
    }

    /**
     * Chemin B : « Demander la publication » sur une annonce en ligne la renvoie aussi en modération
     * (et la masque), sans la dépublier définitivement ni la laisser visible.
     */
    public function test_request_publishing_on_online_ad_sends_it_back_to_moderation(): void
    {
        $ad = $this->createOnlineAd();

        $this->actingAs($ad->userPp)
            ->get('/annonces/request-publishing/'.$ad->id)
            ->assertRedirect(route('ads.show', [$ad->id]));

        $ad->refresh();

        $this->assertSame(0, (int) $ad->is_draft);
        $this->assertSame(AdStatus::PENDING_MODERATION_STATUS_ID, $ad->attributionAd->ad_status_id);
        $this->assertNotNull($ad->attributionAd->pending_update_since);

        auth()->logout();
        $this->get('/annonces/'.$ad->id)->assertStatus(404);
    }

    /**
     * La re-validation par le modérateur remet l'annonce en ligne et lève le marqueur.
     */
    public function test_accepting_brings_the_ad_back_online_and_clears_marker(): void
    {
        $ad = $this->createOnlineAd();

        // L'annonceur modifie → l'annonce est masquée et en attente de modération.
        $this->actingAs($ad->userPp)
            ->post('/annonces/sauvegarder', $this->adFormPayload($ad, 'Titre modifié'));
        $ad->refresh();
        auth()->logout();
        $this->get('/annonces/'.$ad->id)->assertStatus(404);   // masquée (anonyme)

        // Le modérateur revalide (acteur authentifié requis par l'observateur d'historique).
        $this->actingAs($ad->userPp);
        app(AttributionAdsService::class)
            ->acceptAd(['attribution_ad_id' => $ad->attributionAd->id]);

        $ad->refresh();
        $this->assertSame(AdStatus::APPROVE_ID, $ad->attributionAd->ad_status_id);
        $this->assertSame(0, (int) $ad->is_draft);
        $this->assertNull($ad->attributionAd->pending_update_since);

        auth()->logout();
        $this->get('/annonces/'.$ad->id)->assertStatus(200);   // de nouveau visible
    }

    /**
     * Non-régression : un brouillon jamais publié reste invisible du public.
     */
    public function test_never_published_draft_stays_hidden(): void
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

        $this->get('/annonces/'.$ad->id)->assertStatus(404);
    }

    /**
     * La commande de réparation ne modifie rien en dry-run, puis remet l'annonce en ligne.
     */
    public function test_repair_command_dry_run_does_not_change_anything(): void
    {
        $ad = $this->createOnlineAd();
        $this->markAsDraft($ad);

        $this->artisan('ads:repair-published-drafts', ['--dry-run' => true])
            ->assertExitCode(0);

        $ad->refresh();
        $this->assertSame(1, (int) $ad->is_draft);

        $this->artisan('ads:repair-published-drafts')->assertExitCode(0);

        $ad->refresh();
        $this->assertSame(0, (int) $ad->is_draft);
        $this->get('/annonces/'.$ad->id)->assertStatus(200);
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
            'first_name' => 'Role'.$role,
            'email' => uniqid('user-', false).'@example.test',
            'password' => bcrypt('secret'),
            'role' => $role,
        ]);
    }
}
