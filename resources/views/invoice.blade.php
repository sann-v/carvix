@extends('layouts.app')
@section('title', 'Faktur Digital — Carvix')

@push('styles')
<style>
@media print {
  .navbar,.footer,.invoice-actions,.alert-success,.alert-error-flash{display:none!important}
  .invoice-section{padding:0!important}
  .invoice-card{box-shadow:none!important;border:1px solid #ddd!important}
}
</style>
@endpush

@section('content')
<section class="invoice-section">
    <div class="container invoice-container">

        <div class="invoice-actions">
            <div>
                <a href="{{ route('history') }}"
                   style="font-size:.82rem;color:var(--orange);font-weight:600;text-decoration:none">← Kembali ke Riwayat</a>
                <h2 style="margin-top:.5rem">Faktur Digital</h2>
            </div>
            @if(isset($invoice))
            <div style="display:flex;gap:.75rem">
                <button onclick="window.print()" class="btn-sm outline">Unduh PDF</button>
            </div>
            @endif
        </div>

        {{-- ══════════════ TIDAK ADA FAKTUR ══════════════ --}}
        @if(!isset($invoice) || !$invoice)
        <div style="text-align:center;padding:5rem 2rem;background:var(--light);border-radius:var(--radius-lg);border:2px dashed var(--border)">
            <div style="font-size:3rem;margin-bottom:1rem">🧾</div>
            <h3 style="font-size:1.3rem;margin-bottom:.6rem">Belum Ada Faktur</h3>
            <p style="color:var(--text-m);max-width:400px;margin:0 auto .3rem">
                Faktur akan diterbitkan otomatis setelah servis kendaraan Anda selesai dan admin memproses tagihan.
            </p>

            </div>
        </div>
        @endif
        <div class="invoice-card">
            {{-- HEADER --}}
            <div class="invoice-header">
                <div class="invoice-brand">
                    <span class="logo-icon large">◈</span>
                    <div>
                        <h2>CARVIX</h2>
                        <p>Skensa Auto Service</p>
                        <p>Jl. Cokroaminoto No.84, Pemecutan Kaja </p>
                        <p>Denpasar Utara </p>
                        <p>+62 812 3871 6369 · info@carvix.id</p>
                    </div>
                </div>
                <div class="invoice-meta">
                    <span class="badge {{ $invoice->payment_badge }} badge-lg">
                        @if($invoice->isPaid()) LUNAS
                        @elseif($invoice->payment_status === 'cancelled')  DIBATALKAN
                        @elseif($invoice->isOverdue())  JATUH TEMPO
                        @else MENUNGGU PEMBAYARAN
                        @endif
                    </span>
                    <p style="margin-top:.75rem"><strong>{{ $invoice->invoice_number }}</strong></p>
                    <p style="font-size:.82rem;color:var(--text-m)">Diterbitkan: {{ $invoice->issue_date->format('d M Y') }}</p>
                    <p style="font-size:.82rem;color:var(--text-m)">Jatuh Tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                    @if($invoice->paid_at)
                    <p style="font-size:.82rem;color:#16a34a;font-weight:600">Lunas: {{ $invoice->paid_at->format('d M Y, H:i') }}</p>
                    @endif
                    <p style="font-size:.82rem;color:var(--text-m)">Booking: <strong>{{ $invoice->booking->booking_code }}</strong></p>
                </div>
            </div>

            {{-- INFO PELANGGAN & KENDARAAN --}}
            <div class="invoice-info-grid">
                <div>
                    <p class="info-label">INFORMASI PELANGGAN</p>
                    <h4>{{ $invoice->booking->vehicle->owner_name }}</h4>
                    <p>{{ $invoice->booking->vehicle->email }}</p>
                    <p>{{ $invoice->booking->vehicle->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="info-label">SPESIFIKASI KENDARAAN</p>
                    <h4>{{ $invoice->booking->vehicle->year }} {{ $invoice->booking->vehicle->brand }} {{ $invoice->booking->vehicle->model }}</h4>
                    <p>Plat: {{ $invoice->booking->vehicle->license_plate }}</p>
                    <p>VIN: {{ $invoice->booking->vehicle->vin }}</p>
                </div>
            </div>

            {{-- TABEL ITEM --}}
            <div class="invoice-table-wrap">
                <p class="info-label">RINCIAN LAYANAN & SUKU CADANG</p>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>DESKRIPSI</th>
                            <th>QTY</th>
                            <th>HARGA SATUAN</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($invoice->items && count($invoice->items) > 0)
                            @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $invoice->booking->service_type }}</td>
                                <td>1</td>
                                <td>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="invoice-totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="total-row">
                        <span>Pajak ({{ $invoice->subtotal > 0 ? round(($invoice->tax / $invoice->subtotal) * 100) : 11 }}%)</span>
                        <span>Rp {{ number_format($invoice->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="total-row total-final" style="display:flex;flex-direction:column;align-items:flex-start;gap:.75rem;">

                    <div class="total-row total-final" style="display:flex;flex-direction:column;align-items:flex-start;gap:.75rem;">

                    <div style="width:100%;display:flex;justify-content:space-between;">
                        <span>TOTAL PEMBAYARAN</span>
                        <span>Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                    </div>

                    <a href="https://wa.me/6281238716369?text={{ urlencode(
                        'Halo Admin Carvix, saya ingin konfirmasi pembayaran invoice ' .
                        $invoice->invoice_number
                    ) }}"
                    target="_blank"
                    class="btn-wa">
                        Hubungi Admin Untuk Pembayaran
                    </a>

                </div>
                </div>
            </div>

            {{-- Catatan servis --}}
            @if($invoice->booking->admin_notes)
            <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border)">
                <p class="info-label">CATATAN SERVIS</p>
                <p style="font-size:.88rem;color:var(--text-m);margin-top:.5rem">{{ $invoice->booking->admin_notes }}</p>
            </div>
            @endif

            {{-- Footer faktur --}}
            <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border);text-align:center;color:var(--text-l);font-size:.78rem">
                <p>Terima kasih telah mempercayakan kendaraan Anda kepada <strong>Skensa Auto Service</strong></p>
                <p style="margin-top:.3rem">Pertanyaan? Hubungi <strong>+62 812 3871 6369</strong> atau <strong>info@carvix.id</strong></p>
            </div>
        </div>

    </div>
</section>
@endsection
