<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;
use OpenApi\Annotations as OA;
use OpenApi\Annotations\Info;

/**
 * @OA\Info(title="Objectif Terres API", version="1.0")
 */
class ApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/annonces",
     *     @OA\Response(response="200", description="Annonces", @OA\JsonContent(type="array", @OA\Items(
     *          @OA\Property(property="id", type="integer"),
     *          @OA\Property(property="link", type="string"),
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="type", type="string"),
     *          @OA\Property(property="type_label", type="string", enum={"Vente", "Recherche", "Offre d'emploi", "Recherche d'emploi", "Recherche Associé pour un ferme existante", "Recherche d'associé pour un projet d'installation"}),
     *          @OA\Property(property="offer_types", type="string", nullable=true, default=null),
     *          @OA\Property(property="image", type="string"),
     *          @OA\Property(property="surface", type="string", nullable=true, default=null),
     *          @OA\Property(property="region_name", type="string"),
     *          @OA\Property(property="region_code", type="string"),
     *          @OA\Property(property="department_name", type="string", nullable=true, default=null),
     *          @OA\Property(property="department_code", type="string", nullable=true, default=null),
     *          @OA\Property(property="created_at", type="integer"),
     *          @OA\Property(property="updated_at", type="integer"),
     *     ))),
     *     @OA\Parameter(name="limit", in="query", description="Nombre d'annonces à retourner", required=false, @OA\Schema(type="integer", minimum=1, maximum=100, default="4")),
     *     @OA\Parameter(name="type", in="query", description="Type d'annonce. Par défaut les annonces de type landOfferAd et landSeekAd sont retournées.", required=false, @OA\Schema(type="string", enum={"landOfferAd", "landSeekAd", "jobOfferAd", "jobSeekAd", "associateOfferAd", "associateSeekAd"})),
     *     @OA\Parameter(name="region", in="query", description="Code INSEE de la région", required=false, @OA\Schema(type="string")),
     *     security={{"api_key": {}}},
     * )
     * @OA\Tag(name="Lire des annonces. Les requêtes sont mises en cache pendant 1 heure."),
     *
     * @throws \Exception
     */
    public function annonces(Request $request): \Illuminate\Http\JsonResponse
    {
        // Check bearer token
        $token = $request->header('Ot-api-key');
        if ($token !== config('app.api_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'limit' => 'integer|min:1|max:100',
            'type' => 'string|in:landOfferAd,landSeekAd,jobOfferAd,jobSeekAd,associateOfferAd,associateSeekAd',
            'region' => 'string|exists:regions,code',
        ]);

        if(config('app.env') === 'production'){
            $this->middleware('throttle:60,1');
        }
        else {
            cache()->forget('api-ads-' . md5(json_encode($request->all())));
        }

        return response()->json(cache()->remember('api-ads-' . md5(json_encode($request->all())), 3600, function () use ($request) {
            $adsQuery = Ad::whereHas('attributionAd', function (Builder $query) {
                    $query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
                })
                ->whereHas('documents', function (Builder $query) {
                    $query->where('type', 'LIKE', 'image%');
                })
                ->where('is_draft', '=', 0)
                ->with(['documents', 'regions', 'departments', 'cities', 'landOfferAd.offerGenres'])
                ->limit($request->get('limit', 4))
                ->orderBy('created_at', 'desc');

            if($request->has('type') && in_array($request->get('type'), array_keys(Ad::AD_TYPES))){
                $adsQuery->filterAdTypes([$request->get('type')]);
            } else {
                $adsQuery->where(function (Builder $query) {
                    $query->whereHas('landOfferAd')->orWhereHas('landSeekAd');
                });
            }

            if($request->has('region')) {
                $adsQuery->filterRegions($request->get('region'));
            }

            return $adsQuery
                ->get()
                ->map(function (Ad $ad) {
                    $firstImageDocument = $ad->documents->first(fn(Document $document) => str_starts_with($document->type, 'image'));

                    $surface = null;
                    if ($ad->type === 'landOfferAd') {
                        $surface = $ad->landOfferAd->surface;
                    } elseif ($ad->type === 'landSeekAd') {
                        $min = $ad->landSeekAd->surface_range_min;
                        $max = $ad->landSeekAd->surface_range_max;

                        if ($min === $max) {
                            $surface = $min;
                        } else if ($max === 1000000) {
                            if ($min === 0) {
                                $surface = "∞";
                            } else {
                                $surface = 'Au moins ' . $min;
                            }
                        } else if ($min === 0) {
                            $surface = 'Jusqu\'à ' . $max;
                        } else {
                            $surface = $min . ' - ' . $max;
                        }
                    }

                    $category = match ($ad->type) {
                        "landOfferAd" => "Offre de terres",
                        "landSeekAd" => "Recherche de terres",
                        "jobOfferAd" => "Offre d'emploi",
                        "jobSeekAd" => "Recherche d'emploi",
                        "associateOfferAd" => "Recherche Associé pour un ferme existante",
                        "associateSeekAd" => "Recherche d'associé pour un projet d'installation",
                    };
                    $offerTypes = null;
                    if ($ad->type === 'landOfferAd') {
                        $offerTypes = $ad->landOfferAd->offerGenres->pluck('name')->join(', ');
                    }

                    $region = null;
                    $foundDepartment = null;
                    if ($ad->regions->count()) {
                        $region = $ad->regions->first();
                    }
                    if ($ad->departments->count()) {
                        $foundDepartment = $ad->departments->first();
                        if (!$region) {
                            $region = $foundDepartment?->region?->first();
                        }
                    } elseif ($ad->cities->count()) {
                        $foundDepartment = $ad->cities->first()?->department?->first();
                        if (!$region) {
                            $region = $foundDepartment?->region?->first();
                        }
                    }

                    return [
                        'id' => $ad->id,
                        'link' => route('ads.show', $ad->id),
                        'title' => $ad->title,
                        'type' => $ad->type,
                        'type_label' => $category,
                        'offer_types' => $offerTypes,
                        'image' => $firstImageDocument->url,
                        'surface' => $surface,
                        'region_name' => $region?->code,
                        'region_code' => $region?->name,
                        'department_name' => $foundDepartment?->name,
                        'department_code' => $foundDepartment?->code,
                        'created_at' => $ad->created_at->timestamp,
                        'updated_at' => $ad->updated_at->timestamp,
                    ];
                });
        }));
    }
}
