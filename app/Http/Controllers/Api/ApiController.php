<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdIndexRequest;
use App\Http\Resources\AdCollection;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Objectif Terres API",
 *     version="2.0"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="apiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Ot-api-key",
 *     description="API Key for authentication"
 * )
 */
class ApiController extends Controller
{

    /**
     * Get ads with advanced filtering and pagination
     *
     * @OA\Get(
     *     path="/api/v1/ads",
     *     operationId="getAds",
     *     tags={"Objectif Terres API"},
     *     summary="Get ads",
     *     description="Returns ads with pagination and filtering options.",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @OA\Parameter(
     *         name="Ot-api-key",
     *         in="header",
     *         required=true,
     *         description="API Key for authentication",
     *         @OA\Schema(type="string"),
     *         example="sk_prod_Sf9xK2mN8pQ3vL7zY4wB6hJ1nD5gT0aE"
     *     ),
     *     @OA\Parameter(
     *         name="types[]",
     *         in="query",
     *         description="Filter by ad types. Accepts array format (?types[]=land_offer&types[]=land_seek) or comma-separated string (?types=land_offer,land_seek)",
     *         required=false,
     *         style="form",
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum={"land_offer", "land_seek", "job_offer", "job_seek", "associate_offer", "associate_seek"}
     *             )
     *         ),
     *         example={"land_offer", "land_seek"}
     *     ),
     *     @OA\Parameter(
     *         name="updated_since",
     *         in="query",
     *         description="Get ads updated after this date. MUST be in UTC timezone with ISO 8601 format (YYYY-MM-DDTHH:MM:SSZ). Clients must convert their local times to UTC before making the request.",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date-time"
     *         ),
     *         example="2025-09-25T00:00:00Z"
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             minimum=1,
     *             default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             minimum=1,
     *             maximum=100,
     *             default=20
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with ads data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/AdResource")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 ref="#/components/schemas/Pagination"
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 ref="#/components/schemas/Meta"
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 ref="#/components/schemas/Links"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="bad_request"),
     *             @OA\Property(property="message", type="string", example="Invalid date format for updated_since parameter"),
     *             @OA\Property(
     *                 property="details",
     *                 type="object",
     *                 @OA\Property(property="parameter", type="string", example="updated_since"),
     *                 @OA\Property(property="expected_format", type="string", example="YYYY-MM-DDTHH:MM:SSZ"),
     *                 @OA\Property(property="received", type="string", example="2025-07-18")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing API credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="unauthorized"),
     *             @OA\Property(property="message", type="string", example="Invalid or missing API key")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests - Rate limit exceeded",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="rate_limit_exceeded"),
     *             @OA\Property(property="message", type="string", example="API rate limit exceeded. Please retry after 60 seconds."),
     *             @OA\Property(property="retry_after", type="integer", example=60)
     *         )
     *     )
     * )
     */
    public function ads(AdIndexRequest $request): \Illuminate\Http\JsonResponse
    {
        $cacheKey = 'api-ads-v2-' . md5(json_encode($request->all()));

        // Clear cache in development
        if (config('app.env') !== 'production') {
            cache()->forget($cacheKey);
        }

        $data = cache()->remember($cacheKey, 3600, function () use ($request) {
            $query = $this->buildAdsQuery($request);

            // Apply pagination if requested
            if ($request->wantsPagination()) {
                $perPage = $request->getPerPage();
                return $query->paginate($perPage);
            } else {
                // Default limit for non-paginated requests
                $limit = $request->getPerPage();
                return $query->limit($limit)->get();
            }
        });

        // Validate page number if paginated
        if ($data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
            $currentPage = $data->currentPage();
            $lastPage = $data->lastPage();

            if ($currentPage > $lastPage && $lastPage > 0) {
                return response()->json([
                    'error' => 'bad_request',
                    'message' => "Page {$currentPage} does not exist. The last available page is {$lastPage}.",
                    'details' => [
                        'parameter' => 'page',
                        'requested_page' => $currentPage,
                        'last_page' => $lastPage,
                    ],
                ], 400);
            }
        }

        // Return using the new resource collection
        return response()->json(new AdCollection($data));
    }

    /**
     * Build the query for retrieving ads
     */
    protected function buildAdsQuery($request)
    {
        $adsQuery = Ad::query()
            ->whereHas('attributionAd', function (Builder $query) {
                $query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
            })
            ->where('is_draft', '=', 0);

        // Eager load all necessary relationships
        $adsQuery->with([
            'documents',
            'regions',
            'departments',
            'cities',
            'attributionAd.adStatus',
            'attributionAd.userModerator',
            'userPp',
            'thirdPartyAdUser',
            'landOfferAd.offerGenres',
            'landOfferAd.building',
            'landOfferAd.house',
            'landSeekAd.offerGenres',
            'landSeekAd.installationType',
            'jobOfferAd',
            'jobSeekAd',
            'associateOfferAd',
            'associateSeekAd',
        ]);

        // Apply type filters
        $types = $request->getTypes();
        if ($types && count($types) > 0) {
            $adsQuery->filterAdTypes($types);
        }

        // Apply date filter
        if ($request->has('updated_since')) {
            $date = Carbon::parse($request->get('updated_since'));
            $adsQuery->where('updated_at', '>=', $date);
        }

        // Order by created_at
        $adsQuery->orderBy('created_at', 'desc');

        return $adsQuery;
    }
}