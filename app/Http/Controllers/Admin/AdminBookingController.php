<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query  = Booking::with(['vehicle', 'invoice'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(12);

        $counts = [
            'all'         => Booking::count(),
            'pending'     => Booking::where('status', 'pending')->count(),
            'confirmed'   => Booking::where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('status', 'in_progress')->count(),
            'completed'   => Booking::where('status', 'completed')->count(),
            'cancelled'   => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'status', 'counts'));
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle', 'services', 'invoice'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::with(['vehicle', 'invoice'])->findOrFail($id);

        $validated = $request->validate([
            'status'           => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'handled_by'       => 'nullable|string|max:100',
            'admin_notes'      => 'nullable|string|max:2000',
            'estimated_finish' => 'nullable|date',
            'service_cost'     => 'nullable|numeric|min:0',
            // field faktur
            'invoice_items'         => 'nullable|array',
            'invoice_items.*.description' => 'required_with:invoice_items|string',
            'invoice_items.*.qty'         => 'required_with:invoice_items|numeric|min:1',
            'invoice_items.*.unit_price'  => 'required_with:invoice_items|numeric|min:0',
            'payment_status'              => 'nullable|in:unpaid,paid,cancelled',
        ]);

        $progressMap = [
            'pending'     => 0,
            'confirmed'   => 25,
            'in_progress' => 60,
            'completed'   => 100,
            'cancelled'   => 0,
        ];

        $booking->update([
            'status'           => $validated['status'],
            'progress'         => $progressMap[$validated['status']],
            'specialist'       => $validated['handled_by'] ?? $booking->specialist,
            'handled_by'       => $validated['handled_by'] ?? $booking->handled_by,
            'admin_notes'      => $validated['admin_notes'] ?? $booking->admin_notes,
            'estimated_finish' => $validated['estimated_finish'] ?? $booking->estimated_finish,
            'service_cost'     => $validated['service_cost'] ?? $booking->service_cost,
        ]);

        // ────────────────────────────────────────────────
        // Hitung items & total dari form
        // ────────────────────────────────────────────────
        $items    = [];
        $subtotal = 0;

        if (!empty($validated['invoice_items'])) {
            foreach ($validated['invoice_items'] as $item) {
                $total     = $item['qty'] * $item['unit_price'];
                $subtotal += $total;
                $items[]   = [
                    'description' => $item['description'],
                    'qty'         => $item['qty'],
                    'unit_price'  => $item['unit_price'],
                    'total'       => $total,
                ];
            }
        } elseif (!empty($validated['service_cost'])) {
            // fallback: 1 item dari service_cost
            $subtotal = (float) $validated['service_cost'];
            $items    = [[
                'description' => $booking->service_type,
                'qty'         => 1,
                'unit_price'  => $subtotal,
                'total'       => $subtotal,
            ]];
        }

        $tax   = round($subtotal * 0.11, 2);
        $total = $subtotal + $tax;

        if ($subtotal > 0) {
            $paymentStatus = $validated['payment_status'] ?? 'unpaid';

            if ($booking->invoice) {
                // Update invoice yang sudah ada
                $booking->invoice->update([
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'total'          => $total,
                    'items'          => $items,
                    'payment_status' => $paymentStatus,
                    'paid_at'        => $paymentStatus === 'paid' ? now() : $booking->invoice->paid_at,
                ]);
            } else {
                // Buat invoice baru
                Invoice::create([
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                    'booking_id'     => $booking->id,
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'total'          => $total,
                    'items'          => $items,
                    'payment_status' => $paymentStatus,
                    'issue_date'     => now(),
                    'due_date'       => now()->addDays(14),
                    'paid_at'        => $paymentStatus === 'paid' ? now() : null,
                ]);
            }
        }

        return back()->with('success', 'Booking #' . $booking->booking_code . ' berhasil diperbarui.');
    }
}