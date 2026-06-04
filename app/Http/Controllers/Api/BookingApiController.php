<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $vehicles = Vehicle::where('user_id', $user->id)
            ->pluck('id');

        $bookings = Booking::whereIn('vehicle_id', $vehicles)
            ->with(['vehicle', 'invoice'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_name'    => 'required|string|max:100',
            'email'         => 'required|email',
            'phone'         => 'nullable|string',
            'vehicle_brand' => 'required|string',
            'vehicle_model' => 'required|string',
            'year'          => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => 'required|string',
            'vin'           => 'nullable|string',
            'complaint'     => 'nullable|string',
            'service_type'  => 'required|string',
            'service_date'  => 'required|date|after_or_equal:today',
        ]);

        $vehicle = Vehicle::firstOrCreate(
            [
                'license_plate' => $validated['license_plate']
            ],
            [
                'owner_name' => $validated['owner_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'],
                'brand'      => $validated['vehicle_brand'],
                'model'      => $validated['vehicle_model'],
                'year'       => $validated['year'],
                'vin'        => $validated['vin']
                    ?? strtoupper(Str::random(17)),
                'user_id'    => $request->user()->id,
            ]
        );

        $booking = Booking::create([
            'booking_code' =>
                'CRVX-' .
                strtoupper(Str::random(4)) .
                '-' .
                rand(1000, 9999),

            'vehicle_id'   => $vehicle->id,
            'service_type' => $validated['service_type'],
            'complaint'    => $validated['complaint'],
            'service_date' => $validated['service_date'],
            'status'       => 'pending',
            'progress'     => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'booking' => $booking,
            'tracking_vin' => $vehicle->vin
        ], 201);
    }
}