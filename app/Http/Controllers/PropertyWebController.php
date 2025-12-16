<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPropertyNotification;

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
        // 1. Validate
        $request->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'rent_price'   => 'required|numeric|min:1',
            'address'      => 'required',
            'availability' => 'required|boolean',
            'owner_info'   => 'required',
            'images'       => 'nullable|array',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:102400' // 100MB limit
        ]);

        // 2. Handle Images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('property_images', $name, 'public');
                $images[] = $name;
            }
        }

        // 3. Create Property (ONLY ONCE)
        $property = Property::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'rent_price'   => $request->rent_price,
            'address'      => $request->address,
            'availability' => $request->availability,
            'owner_info'   => $request->owner_info,
            'owner_id'     => Auth::id(),
            'images'       => json_encode($images)
        ]);

        // ====================================================
        //                 NOTIFICATIONS
        // ====================================================

        // A. Notify Admins (Bell Icon)
        $admins = User::where('role', 'admin')->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new SystemNotification(
                'New Property Listed: ' . $property->title . ' by ' . Auth::user()->name, 
                url('/admin/properties')
            ));
        }

        // B. Notify the Owner (Bell Icon)
        $user = Auth::user();
        $user->notify(new SystemNotification(
            'Success! Your property "' . $property->title . '" is now live.', 
            url('/owner/properties')
        ));

        // C. NOTIFY ALL USERS (EMAIL + BELL)
        $allUsers = User::all();

        foreach ($allUsers as $targetUser) {
            // Filter: Don't email the person who posted it
            if ($targetUser->id != Auth::id()) {
                
                // 1. Bell Notification
                $targetUser->notify(new SystemNotification(
                    'New Property Alert: ' . $property->title,
                    url('/properties/' . $property->id)
                ));

                // 2. Send Real Email
                try {
                    Mail::to($targetUser->email)->send(new NewPropertyNotification($property));
                } catch (\Exception $e) {
                    \Log::error("Failed to email user {$targetUser->id}: " . $e->getMessage());
                }
            }
        }

        // 4. Final Return (After everything is done)
        return redirect('/owner/dashboard')->with('success', 'Property added and emails sent!');
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