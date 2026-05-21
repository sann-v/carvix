<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('booking', compact('user'));
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
            ['license_plate' => $validated['license_plate']],
            [
                'owner_name' => $validated['owner_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? null,
                'brand'      => $validated['vehicle_brand'],
                'model'      => $validated['vehicle_model'],
                'year'       => $validated['year'],
                'vin'        => $validated['vin'] ?? strtoupper(Str::random(17)),
                'user_id'    => Auth::id(), // link ke user jika login
            ]
        );

        $booking = Booking::create([
            'booking_code' => 'CRVX-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999),
            'vehicle_id'   => $vehicle->id,
            'service_type' => $validated['service_type'],
            'complaint'    => $validated['complaint'] ?? null,
            'service_date' => $validated['service_date'],
            'status'       => 'pending',
            'progress'     => 0,
        ]);

        return redirect()->route('track.show', $vehicle->vin)
            ->with('success', 'Pemesanan dikonfirmasi! Kode: ' . $booking->booking_code);
    }
}