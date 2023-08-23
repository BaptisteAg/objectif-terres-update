<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\ImageManagerStatic;

class ApiController extends Controller
{
    /**
     * @throws \Exception
     */
    public function annonces(Request $request)
    {
        return response()->json(cache()->remember('api-ads-' . md5(json_encode($request->all())), 3600 * 6, function () use ($request) {
            $adsQuery = Ad::whereHas('attributionAd', function (Builder $query) {
                $query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
            })
                ->where(function (Builder $query) {
                    $query->whereHas('landOfferAd')->orWhereHas('landSeekAd');
                })
                ->whereHas('documents', function (Builder $query) {
                    $query->where('type', 'LIKE', 'image%');
                })
                ->where('is_draft', '=', 0)
                ->with(['documents', 'regions', 'departments', 'cities', 'landOfferAd.offerGenres'])
                ->limit($request->get('limit', 4))
                ->orderBy('created_at', 'desc');

            return $adsQuery
                ->get()
                ->map(function (Ad $ad) {
                    $imagePath = $ad->documents->first(fn(Document $document) => str_starts_with($document->type, 'image'))?->path;

                    if ($imagePath && config('app.env') === 'production') {
                        $imagePath = ImageManagerStatic::make(storage_path('app/' . $imagePath))
                            ->resize(300, 200)
                            ->encode('data-url')
                            ->cache(function ($image) {
                                return $image->getEncoded();
                            }, 360 * 24 * 30, true)
                            ->encoded;
                    }

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

                    $type = match ($ad->type) {
                        "landOfferAd" => "Vente",
                        "landSeekAd" => "Recherche"
                    };
                    if ($ad->type === 'landOfferAd') {
                        $type = $ad->landOfferAd->offerGenres->pluck('name')->join(', ');
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
                        'category' => $ad->type,
                        'image' => $imagePath,
                        'type' => $type,
                        'surface' => $surface,
                        'region' => $region?->name,
                        'department_name' => $foundDepartment?->name,
                        'department_code' => $foundDepartment?->code,
                    ];
                });
        }));
    }
}
