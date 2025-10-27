<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use App\Models\HouseFeature;

class HouseFeatureController extends Controller
{
    public function index($houseId)
    {
        $house = House::findOrFail($houseId);
        $features = $house->features;

        return view('product.houses.inside_features.index', compact('house', 'features'));
    }

    public function store(Request $request, $houseId)
    {
        $request->validate([
            'feature' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $house = \App\Models\House::findOrFail($houseId);

        $path = $request->file('feature')->store('house_features', 'public');

        $house->features()->create([
            'image' => $path,
            'caption' => $request->input('caption'),
        ]);

        return redirect()->route('house_features.index', $house->id)
                        ->with('success', 'New feature image uploaded successfully.');
    }
    public function visitorView($houseId)
    {
        $house = House::findOrFail($houseId);
        $features = $house->features;

        return view('product.houses.inside_features.visitor', compact('house', 'features'));
    }

}
