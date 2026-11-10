<?php

namespace App\Http\Controllers\Histories;

use App\Http\Controllers\Controller;
use App\Models\History;

class HistoriesController extends Controller
{
    public function show($adId)
    {
        $histories = History::where('ad_id', $adId)->latest()->get();

        return response()->json([
            'histories' => $histories,
        ]);
    }
}
