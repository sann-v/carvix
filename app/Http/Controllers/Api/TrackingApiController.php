<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class TrackingApiController extends Controller
{
    public function show(string $vin)
    {
        $vehicle = Vehicle::where('vin', $vin)
            ->with([
                'latestBooking.services',
                'latestBooking.invoice'
            ])
            ->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan'
            ], 404);
        }

        $booking = $vehicle->latestBooking;

        $stages = [
            ['name' => 'Kendaraan Diterima'],
            ['name' => 'Inspeksi & Diagnostik'],
            ['name' => 'Servis & Penggantian'],
            ['name' => 'Pemeriksaan Kualitas'],
            ['name' => 'Siap Diambil'],
        ];

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
            'booking' => $booking,
            'invoice' => $booking?->invoice,
            'stages' => $stages,
        ]);
    }
}