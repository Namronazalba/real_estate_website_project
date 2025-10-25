<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;

class HouseController extends Controller
{
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
        if ($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('houses','public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'available';

        House::create($validated);
        return redirect()->route('houses.index')->with('success','House added successfully!');
    }

    public function show($id) { /* ... */ }
    public function edit($id) { /* ... */ }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }
}
