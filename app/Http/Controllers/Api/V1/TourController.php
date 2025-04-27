<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToursListRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index(Travel $travel, ToursListRequest $request)
    {
        // return Tour::where('travel_id', $travel->id)->orderBy('starting_date')->get();
        $query = $travel->tours()
        // if === when
        // using if check conditionally add a where clause
        // if ($request('dateFrom')) {
        //     $query->where('starting_date', '>=', $request('dateFrom'));
        // }
        // using when check conditionally add a where clause
            ->when($request->priceFrom, callback: function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, callback: function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, callback: function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, callback: function ($query) use ($request) {
                $query->where('starting_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy && $request->sortOrder, callback: function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->sortBy->sortOrder);
            });
            $tours = $query->orderBy('starting_date')->get();
        return TourResource::collection($tours);
    }
}
