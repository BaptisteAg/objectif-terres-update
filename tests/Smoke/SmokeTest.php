<?php

namespace Tests\Smoke;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use DatabaseTransactions;

    private const UNSAFE_URI_PATTERNS = [
        '_debugbar', 'deconnexion', 'logout', 'sso', 'saml2', 'export', 'oauth2',
        'nova-api', 'nova-vendor', 'ot-admin', 'docs', 'api/', 'locations/polygon',
        'recherches/notification', 'annonces-favorites/sauvegarde',
    ];

    private const KNOWN_DEFECTS = [
        'accompagnement/modifier',
    ];

    private const ROLES = [
        'porteur de projet' => 0,
        'moderateur' => 1,
        'responsable territorial' => 3,
        'admin' => 4,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Notification::fake();
    }

    public function test_smoke_database_holds_production_data()
    {
        $this->assertSame('objectif_terres_smoke', DB::connection()->getDatabaseName());
        $this->assertGreaterThan(1000, User::count());
    }

    public function test_public_pages_do_not_crash()
    {
        $this->assertNoServerErrors($this->parameterlessGetUris(), null);
    }

    public function test_pages_do_not_crash_for_each_role()
    {
        foreach (self::ROLES as $label => $role) {
            $user = User::where('role', $role)->whereNull('deleted_at')->orderBy('id')->firstOrFail();

            $this->assertNoServerErrors($this->parameterlessGetUris(), $user, $label);
        }
    }

    public function test_ad_pages_do_not_crash()
    {
        $adIds = DB::table('attribution_ads')
            ->join('ads', 'ads.id', '=', 'attribution_ads.ad_id')
            ->whereNull('ads.deleted_at')
            ->where('attribution_ads.ad_status_id', \App\Models\AdStatus::APPROVE_ID)
            ->whereNotNull('attribution_ads.published_on')
            ->whereNull('attribution_ads.archived_at')
            ->orderByDesc('ads.id')
            ->limit(15)
            ->pluck('ads.id');

        $this->assertCount(15, $adIds);
        $admin = $this->admin();

        $uris = $adIds->map(fn ($id) => "annonces/{$id}")->all();

        $this->assertNoServerErrors($uris, null, 'anonyme');
        $this->assertNoServerErrors($uris, $admin, 'admin');
    }

    public function test_nova_resources_do_not_crash()
    {
        $admin = $this->admin();
        $uris = ['ot-admin', 'nova-api/dashboards/main'];

        foreach (glob(app_path('Nova/*.php')) as $file) {
            $class = 'App\\Nova\\'.basename($file, '.php');
            if (! is_subclass_of($class, \Laravel\Nova\Resource::class) || (new \ReflectionClass($class))->isAbstract()) {
                continue;
            }

            $uriKey = $class::uriKey();
            $model = $class::$model;
            $firstId = $model::query()->orderBy((new $model)->getKeyName())->value((new $model)->getKeyName());

            $uris[] = "ot-admin/resources/{$uriKey}";
            $uris[] = "nova-api/{$uriKey}?perPage=25";
            $uris[] = "nova-api/{$uriKey}/filters";
            $uris[] = "nova-api/{$uriKey}/actions";
            if ($firstId !== null) {
                $uris[] = "nova-api/{$uriKey}/{$firstId}";
                $uris[] = "nova-api/{$uriKey}/{$firstId}/update-fields";
            }
        }

        $this->assertNoServerErrors($uris, $admin, 'admin Nova', ['Accept' => 'application/json']);
    }

    private function admin(): User
    {
        return User::where('role', self::ROLES['admin'])->whereNull('deleted_at')->orderBy('id')->firstOrFail();
    }

    private function parameterlessGetUris(): array
    {
        return collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route) => in_array('GET', $route->methods()))
            ->map(fn ($route) => $route->uri())
            ->reject(fn ($uri) => Str::contains($uri, '{') || Str::contains($uri, self::UNSAFE_URI_PATTERNS) || in_array($uri, self::KNOWN_DEFECTS))
            ->unique()
            ->values()
            ->all();
    }

    private function assertNoServerErrors(array $uris, ?User $user, string $label = 'anonyme', array $headers = []): void
    {
        $failures = [];
        $unsuccessful = 0;

        foreach ($uris as $uri) {
            $this->refreshApplicationState($user);
            $response = $this->withHeaders($headers)->get(rtrim(config('app.url'), '/').'/'.ltrim($uri, '/'));

            if (! $response->isSuccessful()) {
                $unsuccessful++;
            }

            if ($response->getStatusCode() >= 500) {
                $exception = $response->exception;
                $failures[] = sprintf(
                    '[%s] /%s -> %d %s',
                    $label,
                    ltrim($uri, '/'),
                    $response->getStatusCode(),
                    $exception ? get_class($exception).': '.Str::limit($exception->getMessage(), 200) : ''
                );
            }
        }

        $this->assertSame([], $failures, implode(PHP_EOL, $failures));
        $this->assertLessThan(count($uris) / 2, $unsuccessful, "[{$label}] plus de la moitié des pages ne répondent pas 2xx, le test ne vérifie rien");
    }

    private function refreshApplicationState(?User $user): void
    {
        $this->flushSession();

        if ($user) {
            $this->actingAs($user);
        }
    }
}
