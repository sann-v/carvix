<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending'     => Booking::where('status', 'pending')->count(),
            'confirmed'   => Booking::where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('status', 'in_progress')->count(),
            'completed'   => Booking::where('status', 'completed')->count(),
        ];

        $recentBookings = Booking::with('vehicle')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}