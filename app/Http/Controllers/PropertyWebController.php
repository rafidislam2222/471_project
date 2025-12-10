<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyWebController extends Controller
{
    // Show properties belonging ONLY to the logged-in owner
    public function index()
    {
        $ownerId = Auth::id();

        $properties = Property::where('owner_id', $ownerId)->get();

        return view('owner.properties.index', compact('properties'));
    }

    // Show add property form
    public function create()
    {
        return view('owner.properties.create');
    }

    // Save new property
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'rent_price'   => 'required|numeric|min:1',
            'address'      => 'required',
            'availability' => 'required|boolean',
            'owner_info'   => 'required',
            'images' => 'nullable|array',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:102400'
        ]);

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('property_images', $name, 'public');
                $images[] = $name;
            }
        }

        Property::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'rent_price'   => $request->rent_price,
            'address'      => $request->address,
            'availability' => $request->availability,
            'owner_info'   => $request->owner_info,
            'owner_id'     => Auth::id(),         // ✅ Link property to the owner
            'images'       => json_encode($images)
        ]);

        return redirect('/owner/dashboard')->with('success', 'Property added successfully!');

    }

    // Show edit form
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('owner.properties.edit', compact('property'));
    }

    // Update property
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'rent_price'   => 'required|numeric|min:1',
            'address'      => 'required',
            'availability' => 'required|boolean',
            'owner_info'   => 'required',
        ]);

        $property = Property::findOrFail($id);

        $property->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'rent_price'   => $request->rent_price,
            'address'      => $request->address,
            'availability' => $request->availability,
            'owner_info'   => $request->owner_info,
        ]);

        return redirect('/owner/properties')->with('success', 'Property updated successfully!');
    }

    // Delete property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect('/owner/properties')->with('success', 'Property deleted successfully!');
    }
}
