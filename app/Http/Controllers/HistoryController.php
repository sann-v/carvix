<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua kendaraan user
        $vehicleIds = Vehicle::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->pluck('id');

        // Ambil semua booking dari semua kendaraan
        $bookings = Booking::whereIn('vehicle_id', $vehicleIds)
            ->with(['vehicle', 'services', 'invoice'])
            ->orderByDesc('created_at')
            ->paginate(10);

        // optional: buat banner kendaraan terakhir
        $vehicle = Vehicle::whereIn('id', $vehicleIds)
            ->latest()
            ->first();

        return view('history', compact('bookings', 'vehicle', 'user'));
    }
}