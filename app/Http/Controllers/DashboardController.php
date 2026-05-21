<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari semua kendaraan milik user
        $vehicles = Vehicle::where('user_id', $user->id)
                           ->orWhere('email', $user->email)
                           ->latest()
                           ->get();

        $vehicle = $vehicles->first();

        $activeBooking = null;
        $stats = ['total_bookings' => 0, 'completed' => 0, 'in_progress' => 0];

        if ($vehicle) {
            // Load semua relasi termasuk handled_by, admin_notes, dll
            $activeBooking = Booking::where('vehicle_id', $vehicle->id)
                ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'cancel'])
                ->with(['invoice'])
                ->latest()
                ->first();
            
            $completedBooking = Booking::whereIn('vehicle_id', $vehicles->pluck('id'))
                ->where('status', ['completed', 'cancelled'])
                ->with(['invoice'])
                ->latest()
                ->first();

            $allBookings = Booking::whereIn('vehicle_id', $vehicles->pluck('id'))
                ->get();

            $stats = [
                'total_bookings' => $allBookings->count(),
                'completed'      => $allBookings->where('status', 'completed')->count(),
                'in_progress'    => $allBookings->whereIn('status', ['in_progress', 'confirmed'])->count(),
            ];
        }

        return view('dashboard', compact('vehicle', 'vehicles', 'activeBooking', 'completedBooking', 'stats', 'user'));
    }
}
