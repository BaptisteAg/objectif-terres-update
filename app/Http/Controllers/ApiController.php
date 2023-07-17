<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatus;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ApiController extends Controller
{
    //

    public function annonces() {

        $ads = Ad::whereHas('attributionAd', function (Builder $query) {
            $query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
        })->where('is_draft', '=', 0)->take(4)->orderBy('created_at', 'desc')->get()->shuffle();

        return response()->json($ads);
    }
}
