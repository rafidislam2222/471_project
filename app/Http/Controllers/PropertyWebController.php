<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\GmailService; // Import the service we created
use App\Mail\NewPropertyNotification; // Import the Mailable

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


        //|Notification to admin about new property added
        $admins = User::where('role', 'admin')->get();
        
        if($admins->count() > 0) {
            Notification::send($admins, new SystemNotification(
                'New Property Listed: ' . $property->title . ' by ' . Auth::user()->name, 
                url('/admin/properties') // Link for admin to view
            ));
        }

        //Notify the Owner (Confirmation)
        $user = Auth::user();
        $user->notify(new SystemNotification(
            'Success! Your property "' . $property->title . '" is now live.', 
            url('/owner/properties') // Link for owner to view
        ));

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
    public function sendNotification(Request $request)
    {
        // Validate
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        // Find user and send
        $user = User::find($request->user_id);
        $user->notify(new SystemNotification($request->message));

        return back()->with('success', 'Notification sent successfully!');
    }
}
class PropertyController extends Controller
{
    public function store(Request $request, GmailService $gmail)
    {
        // 1. Validate the Request data (Not shown, but necessary)
        // $request->validate([...]);

        // 2. Create the Property
        $property = Property::create($request->all());

        // 3. Email Logic using the Gmail Service
        try {
            // Check the connection and refresh the token if necessary
            if (!$gmail->connect()) {
                // Log this failure and maybe notify the admin
                \Log::error('Gmail API token requires re-authorization.'); 
                // Return or continue without sending emails
            } else {
                // Get all users (You might want to filter by role, e.g., ->where('role', 'tenant'))
                $users = User::all();
                
                // Chunk the users to prevent memory issues for very large lists
                $users->chunk(50)->each(function ($chunk) use ($gmail, $property) {
                    foreach ($chunk as $user) {
                        
                        // Render the Mailable's content
                        $mailable = (new NewPropertyNotification($property))->render();
                        
                        // Get the subject from the Mailable
                        $subject = (new NewPropertyNotification($property))->envelope()->subject;

                        // Use our custom service to send the email
                        $gmail->sendEmail(
                            $user->email,  // Recipient email
                            $subject,      // Subject line
                            $mailable      // HTML body content
                        );
                    }
                });
            }

        } catch (\Exception $e) {
            // Log any failures during the sending process
            \Log::error('Failed to send bulk email notification: ' . $e->getMessage());
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property added and notifications sent!');
    }
}