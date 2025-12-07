<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    // ==================================
    // FEATURE 1 — CRUD OPERATIONS
    // ==================================

    // GET /api/properties  → list all properties
    public function index()
    {
        return response()->json(Property::all(), 200);
    }

    // POST /api/properties  → create new property
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'rent_price'   => 'required|numeric',
            'address'      => 'required|string',
            'availability' => 'required|boolean',
            'owner_info'   => 'required|string',
        ]);

        $property = Property::create($data);

        return response()->json($property, 201);
    }

    // GET /api/properties/{id}  → show one property
    public function show($id)
    {
        $property = Property::find($id);

        if (! $property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json($property, 200);
    }

    // PUT /api/properties/{id}  → update property
    public function update(Request $request, $id)
    {
        $property = Property::find($id);

        if (! $property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $data = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'rent_price'   => 'sometimes|required|numeric',
            'address'      => 'sometimes|required|string',
            'availability' => 'sometimes|required|boolean',
            'owner_info'   => 'sometimes|required|string',
        ]);

        $property->update($data);

        return response()->json($property, 200);
    }

    // DELETE /api/properties/{id}  → delete property
    public function destroy($id)
    {
        $property = Property::find($id);

        if (! $property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $property->delete();

        return response()->json(['message' => 'Property deleted successfully'], 200);
    }


    // ==================================
    // FEATURE 2 — WEATHER (OpenWeather)
    // ==================================

    // GET /api/properties/{id}/weather
    public function getWeather($id)
    {
        $property = Property::find($id);
        if (! $property) {
            return response()->json(['message' => 'Property not found'], 404);
        }
        // 1) Read API key from .env
        $apiKey = env('OPENWEATHER_KEY');

        if (! $apiKey) {
            return response()->json([
                'error' => 'OpenWeather API key missing (set OPENWEATHER_KEY in .env)',
            ], 500);
        }
        // 2) Use address as city (replace spaces with +)
        $city = str_replace(' ', '+', $property->address);
        try {
            // 3) Call OpenWeather API
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q'     => $city,
                'appid' => $apiKey,
                'units' => 'metric',   // Celsius
            ]);
        } catch (\Exception $e) {
            // Network / DNS / SSL errors, etc.
            return response()->json([
                'error'   => 'Unable to connect to OpenWeather',
                'details' => $e->getMessage(),
            ], 500);
        }
        // 4) OpenWeather returned error (401, 404, etc.)
        if ($response->failed()) {
            return response()->json([
                'error'  => 'OpenWeather returned error',
                'status' => $response->status(),
                'body'   => $response->json(),
            ], 500);
        }
        $data = $response->json();
        $weather = [
            'temperature' => $data['main']['temp']              ?? null,
            'humidity'    => $data['main']['humidity']          ?? null,
            'condition'   => $data['weather'][0]['description'] ?? null,
        ];
        return response()->json([
            'property' => $property,
            'weather'  => $weather,
        ], 200);
    }
}
