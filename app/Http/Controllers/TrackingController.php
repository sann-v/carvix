<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function show(string $vin)
    {
        $vehicle = Vehicle::where('vin', $vin)
            ->with(['latestBooking.services', 'latestBooking.invoice'])
            ->first();

        if (!$vehicle) {
            return redirect()->route('track')
                ->with('error', 'Kendaraan dengan VIN "' . $vin . '" tidak ditemukan. Pastikan VIN sudah benar.');
        }

        $booking = $vehicle->latestBooking;

        $stages = [
            ['name' => 'Kendaraan Diterima',     ],
            ['name' => 'Inspeksi & Diagnostik',  ],
            ['name' => 'Servis & Penggantian',   ],
            ['name' => 'Pemeriksaan Kualitas',   ],
            ['name' => 'Siap Diambil',           ],
        ];

        return view('tracking', compact('vehicle', 'booking', 'stages'));
    }
}
