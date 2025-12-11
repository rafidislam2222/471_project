<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;
use App\Services\GmailService; // Import the service we created
use Illuminate\Support\Facades\Notification;

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
    public function store(Request $request,GmailService $gmail)
    {
        $request->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'rent_price'   => 'required|numeric|min:1',
            'address'      => 'required',
            'availability' => 'required|boolean',
            'owner_info'   => 'required',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->storeAs('property_images', $name, 'public');
                $images[] = $name;
            }
        }

        $property=Property::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'rent_price'   => $request->rent_price,
            'address'      => $request->address,
            'availability' => $request->availability,
            'owner_info'   => $request->owner_info,
            'owner_id'     => Auth::id(),         //  Link property to the owner
            'images'       => json_encode($images)
        ]);
                            //NOTIFICATIONS////

        // Notify Admins (Database Only)
        $admins = User::where('role', 'admin')->get();
        if($admins->count() > 0) {
            Notification::send($admins, new SystemNotification(
                'New Property Listed: ' . $property->title . ' by ' . Auth::user()->name, 
                url('/admin/properties')
            ));
        }

        // Notify the Owner (Confirmation - Database Only)
        $user = Auth::user();
        $user->notify(new SystemNotification(
            'Success! Your property "' . $property->title . '" is now live.', 
            url('/owner/properties')
        ));

        // NOTIFY ALL TENANTS (Gmail API + Bell Icon)
        if (!$gmail->connect()) {
            \Log::error('Gmail API Token Expired. Emails not sent.');
        }

        $allUsers = User::all();

        foreach ($allUsers as $targetUser) {
            // Don't spam the owner or the admins again (optional filter)
            if ($targetUser->id != Auth::id() && $targetUser->role != 'admin') {
                
                // 1. Bell Icon
                $targetUser->notify(new SystemNotification(
                    'New Property Alert: ' . $property->title,
                    url('/properties/' . $property->id)
                ));

                // 2. Gmail API
                try {
                    $gmail->sendEmail(
                        $targetUser->email,
                        'New Property Alert: ' . $property->title,
                        "A new property is available at " . $property->address . ". \n\nCheck it out here: " . url('/properties/' . $property->id)
                    );
                } catch (\Exception $e) {
                    \Log::error("Failed to email user {$targetUser->id}: " . $e->getMessage());
                }
            }
        }
        // ====================================================

        return redirect('/owner/dashboard')->with('success', 'Property added and notifications sent!');
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