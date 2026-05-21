<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(int $id)
    {
        $invoice = Invoice::with(['booking.vehicle'])->findOrFail($id);

        // Pastikan invoice milik user yang login
        if ($invoice) {
            $vehicle = $invoice->booking->vehicle;
            $isOwner = $vehicle->user_id === Auth::id()
                    || $vehicle->email === Auth::user()->email;

            if (!$isOwner) {
                abort(403, 'Anda tidak memiliki akses ke faktur ini.');
            }
        }

        return view('invoice', compact('invoice'));
    }

    // Halaman faktur kosong (tidak ada invoice untuk booking ini)
    public function empty()
    {
        $invoice = null;
        return view('invoice', compact('invoice'));
    }
}