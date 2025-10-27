<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function welcome()
    {
        $houses = House::where('status', 'available')
            ->latest()
            ->take(9)
            ->get();

        return view('welcome', compact('houses'));
    }

    public function index() { 
        $houses = House::where('status', 'available')
        ->latest()
        ->paginate(9); 

        return view('product.houses.index', compact('houses'));
    }

    public function create() { 
        return view('product.houses.create');
    }
    
    public function store(Request $request) { 
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description'=> 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if (!Storage::disk('public')->exists('houses')) {
            Storage::disk('public')->makeDirectory('houses');
        }
            if ($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('houses','public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'available';

        House::create($validated);
        return redirect()->route('houses.index')->with('success','House added successfully!');
    }
    
    public function edit($id)
    {
        $house = House::findOrFail($id);
        return view('product.houses.edit', compact('house'));
    }

    public function update(Request $request, $id)
    {
        $house = House::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'status' => 'required|in:available,sold,pending',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // If a new image is uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('houses', 'public');
            $validated['image'] = $imagePath;
        }

        $house->update($validated);

        return redirect()->route('houses.index')->with('success', 'House updated successfully.');
    }
    public function show($id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
