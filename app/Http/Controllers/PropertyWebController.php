<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyWebController extends Controller
{
    // Show all properties (Owner dashboard)
    public function index()
    {
        $properties = Property::all();
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
            'rent_price'   => 'required|numeric',
            'address'      => 'required',
            'availability' => 'required|boolean',
            'owner_info'   => 'required',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('public/property_images', $name);
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
            'images'       => json_encode($images)

        ]);

        return redirect('/owner/properties')->with('success', 'Property added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('owner.properties.edit', compact('property'));
    }

    // Update a property
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'rent_price'   => 'required|numeric',
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
