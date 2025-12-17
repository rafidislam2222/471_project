<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\SystemNotification;
use App\Services\GmailService;

class PropertyUserController extends Controller
{
    // Show all properties (available + booked)
    public function index()
    {
        // Show every property, regardless of availability
        $properties = Property::all();

        return view('properties.index', compact('properties'));
    }

    // Show one property + weather + booking form
    public function show($id)
    {
        $property = Property::findOrFail($id);

        // ---- WEATHER (OpenWeather) ----
        $weather = null;
        $apiKey = env('OPENWEATHER_KEY');

        if ($apiKey) {
            try {
                $city = str_replace(' ', '+', $property->address);

                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                    'q'     => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $weather = [
                        'temperature' => $data['main']['temp']              ?? null,
                        'humidity'    => $data['main']['humidity']          ?? null,
                        'condition'   => $data['weather'][0]['description'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                $weather = null; // fail silently for UI
            }
        }

        return view('properties.show', compact('property', 'weather'));
    }

    // 3. Book a property (With Gmail API + Notification)
    public function book(Request $request, $id, GmailService $gmail)
    {
        $property = Property::findOrFail($id);

        if ($property->availability == 0) {
            return back()->with('error', 'This property is already booked.');
        }

        $request->validate([
            'start_date' => 'required|date',
        ]);

        // Create booking record
        Booking::create([
            'user_id'     => Auth::id(),
            'property_id' => $property->id,
            'start_date'  => $request->start_date,
        ]);

        // Mark property as booked
        $property->availability = 0;
        $property->save();

        // --- NOTIFICATIONS START ---
        $user = Auth::user();

        // A. Bell Icon Notification
        $user->notify(new SystemNotification(
            'Booking Confirmed: ' . $property->title,
            url('/properties/' . $property->id)
        ));

        // B. Gmail API Email
        if ($gmail->connect()) {
            try {
                $gmail->sendEmail(
                    $user->email,
                    'Booking Confirmation: ' . $property->title,
                    "Dear " . $user->name . ",\n\n" .
                    "Your booking for " . $property->title . " has been confirmed.\n" .
                    "Start Date: " . $request->start_date . "\n\n" .
                    "Thank you for using our service!"
                );
            } catch (\Exception $e) {
                \Log::error('Booking email failed: ' . $e->getMessage());
            }
        }
        // --- NOTIFICATIONS END ---

        return back()->with('success', 'Property booked! Confirmation sent to your email.');
    }

    // --- NEW: 4. Show User's Booked Properties ---
    public function myBookings()
    {
        // Get bookings for the logged-in user with Property details
        $bookings = Booking::where('user_id', Auth::id())->with('property')->get();
        
        return view('properties.my-bookings', compact('bookings'));
    }

    // --- NEW: 5. Cancel Booking (Update Status) ---
    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Security: Make sure the logged-in user owns this booking
        if ($booking->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 1. Find the property and make it AVAILABLE again
        $property = $booking->property;
        $property->availability = 1; // 1 = Available
        $property->save();

        // 2. Delete the booking
        $booking->delete();

        return back()->with('success', 'Booking cancelled. The property is available again.');
    }
}