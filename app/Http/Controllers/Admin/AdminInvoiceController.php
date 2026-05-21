<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,cancelled',
        ]);

        $invoice = Invoice::with('booking')->findOrFail($id);
        $invoice->update([
            'payment_status' => $request->payment_status,
            'paid_at'        => $request->payment_status === 'paid' ? now() : null,
        ]);

        return back()->with('success',
            'Status pembayaran faktur #' . $invoice->invoice_number . ' diubah menjadi ' .
            ($request->payment_status === 'paid' ? 'LUNAS ✓' : strtoupper($request->payment_status))
        );
    }
}