<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        // return Tour::where('travel_id', $travel->id)->orderBy('starting_date')->get();
        $tours = $travel->tours()->orderBy('starting_date')->get();
        return TourResource::collection($tours);
    }
}
