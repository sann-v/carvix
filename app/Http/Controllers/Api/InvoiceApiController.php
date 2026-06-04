<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    public function show(Request $request, int $id)
    {
        $invoice = Invoice::with([
            'booking.vehicle'
        ])->findOrFail($id);

        $vehicle = $invoice->booking->vehicle;

        $isOwner =
            $vehicle->user_id === $request->user()->id
            || $vehicle->email === $request->user()->email;

        if (!$isOwner) {
            return response()->json([
                'message' => 'Akses ditolak'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $invoice
        ]);
    }
}