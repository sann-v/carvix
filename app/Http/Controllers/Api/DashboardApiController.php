<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $vehicles = Vehicle::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->latest()
            ->get();

        $vehicle = $vehicles->first();

        $activeBooking = null;
        $completedBooking = null;

        $stats = [
            'total_bookings' => 0,
            'completed' => 0,
            'in_progress' => 0
        ];

        if ($vehicle) {

            $activeBooking = Booking::where('vehicle_id', $vehicle->id)
                ->whereIn('status', [
                    'pending',
                    'confirmed',
                    'in_progress',
                    'cancel'
                ])
                ->with('invoice')
                ->latest()
                ->first();

            $completedBooking = Booking::whereIn(
                    'vehicle_id',
                    $vehicles->pluck('id')
                )
                ->whereIn('status', [
                    'completed',
                    'cancelled'
                ])
                ->with('invoice')
                ->latest()
                ->first();

            $allBookings = Booking::whereIn(
                'vehicle_id',
                $vehicles->pluck('id')
            )->get();

            $stats = [
                'total_bookings' => $allBookings->count(),
                'completed' => $allBookings
                    ->where('status', 'completed')
                    ->count(),

                'in_progress' => $allBookings
                    ->whereIn('status', [
                        'in_progress',
                        'confirmed'
                    ])
                    ->count(),
            ];
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'vehicles' => $vehicles,
            'active_booking' => $activeBooking,
            'completed_booking' => $completedBooking,
            'stats' => $stats
        ]);
    }

    public function history(Request $request)
    {
        $user = $request->user();

        $vehicles = Vehicle::where('user_id', $user->id)
            ->pluck('id');

        $history = Booking::whereIn('vehicle_id', $vehicles)
            ->with(['vehicle', 'invoice'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}