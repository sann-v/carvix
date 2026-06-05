@extends('layouts.app')
@section('title', 'Riwayat Layanan — Skensa Auto Service')

@section('content')

<section class="page-hero">
    <div class="page-hero-content">
        <p class="hero-eyebrow">LOG SERVIS KENDARAAN</p>
        <h1>Riwayat <span class="accent">Layanan</span></h1>
        <p>Catatan lengkap setiap servis, diagnostik, dan penggantian suku cadang kendaraan Anda.</p>
    </div>
</section>

<section class="history-section">
    <div class="container">

        @if(isset($vehicle) && $vehicle)
        <div class="history-vehicle-banner">
            <div>
                <p class="eyebrow" style="font-size:0.65rem">KENDARAAN TERDAFTAR</p>
                <h3 style="font-size:1rem;margin-top:0.2rem">{{ $vehicle->year }} {{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                <p style="font-size:0.8rem;color:var(--text-m)">Plat: {{ $vehicle->license_plate }} &nbsp;·&nbsp; VIN: {{ $vehicle->vin }}</p>
            </div>
            <a href="{{ route('booking') }}" class="btn-sm">+ PESAN LAYANAN BARU</a>
        </div>
        @endif

        <div class="history-list">
            @forelse($bookings as $booking)
                <div class="history-card">
                    <div class="history-date">
                        <span class="month">{{ $booking->service_date->format('M') }}</span>
                        <span class="day">{{ $booking->service_date->format('d') }}</span>
                        <span class="year-sm">{{ $booking->service_date->format('Y') }}</span>
                    </div>
                    <div class="history-info">
                        <h3>{{ $booking->service_type }}</h3>
                        <p>{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} ({{ $booking->vehicle->year }})</p>
                        <p class="vin-tag">{{ $booking->booking_code }}</p>
                        @if($booking->handled_by ?? $booking->specialist)
                            <p style="font-size:0.78rem;color:var(--text-l);margin-top:0.2rem">
                                👤 Teknisi: <strong>{{ $booking->handled_by ?? $booking->specialist }}</strong>
                            </p>
                        @endif
                        @if($booking->admin_notes)
                            <p style="font-size:0.78rem;color:var(--text-l);margin-top:0.2rem;font-style:italic">
                                "{{ Str::limit($booking->admin_notes, 80) }}"
                            </p>
                        @endif
                    </div>
                    <div class="history-meta">
                        <span class="badge {{ $booking->status_badge }}">{{ strtoupper(str_replace('_', ' ', $booking->status)) }}</span>
                        @if($booking->invoice)
                            <p class="history-price">Rp {{ number_format($booking->invoice->total, 0, ',', '.') }}</p>
                            <span style="font-size:0.72rem;color:{{ $booking->invoice->payment_status === 'paid' ? '#16a34a' : '#d97706' }};font-weight:600">
                                {{ $booking->invoice->payment_status === 'paid' ? '✓ Lunas' : '⏳ Belum Lunas' }}
                            </span>
                        @endif
                    </div>
                    <div class="history-actions">
                        <a href="{{ route('track.show', $booking->vehicle->vin) }}" class="btn-sm">LACAK</a>
                        @if($booking->invoice)
                            <a href="{{ route('invoice.show', $booking->invoice->id) }}" class="btn-sm outline">FAKTUR</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div style="font-size:3rem;margin-bottom:1rem">📋</div>
                    <h3>Belum Ada Riwayat Layanan</h3>
                    <p>Buat pemesanan pertama Anda untuk mulai melacak riwayat servis kendaraan.</p>
                    <a href="{{ route('booking') }}" class="hbtn hbtn-primary" style="display:inline-flex;margin-top:1.5rem">PESAN LAYANAN PERTAMA</a>
                </div>
            @endforelse
        </div>

        @if(method_exists($bookings, 'links') && $bookings->hasPages())
            <div style="margin-top:2rem">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
