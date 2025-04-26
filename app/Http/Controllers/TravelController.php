<?php

namespace App\Http\Controllers;

use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate(10);

        return TravelResource::collection($travels);
    }

    public function show($slug)
    {
        // Fetch travel by slug
        $travel = Travel::where('slug', $slug)->firstOrFail();

        // Return the view with travel data
        return view('travels.show', compact('travel'));
    }

    public function create()
    {
        // Show form to create a new travel
        return view('travels.create');
    }

    public function store(Request $request)
    {
        // Validate and store the new travel
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'number_of_days' => 'required|integer|min:1',
            'is_public' => 'boolean',
        ]);

        Travel::create($validatedData);

        return redirect()->route('travels.index')->with('success', 'Travel created successfully.');
    }

}
