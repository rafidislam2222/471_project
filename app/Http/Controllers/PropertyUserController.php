<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    // Book a property (start date only)
    public function book(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // If already booked, do not allow booking
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

        return back()->with('success', 'Property booked successfully!');
    }
}
