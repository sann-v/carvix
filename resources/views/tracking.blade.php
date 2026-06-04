@extends('layouts.app')
@section('title', 'Lacak Kendaraan — Carvix')

@section('content')

<section class="page-hero">
    <div class="page-hero-content">
        <p class="hero-eyebrow">PEMANTAUAN WAKTU NYATA</p>
        <h1>Lacak<br><span class="accent">Servis Kendaraan</span></h1>
        <p>Masukkan nomor VIN untuk melihat status layanan kendaraan Anda secara langsung.</p>
    </div>
</section>

<section class="tracking-section">
    <div class="container">

        @if(!isset($vehicle))
        <!-- FORMULIR PENCARIAN -->
        <div class="track-search-wrap">
            <div class="track-search">
                <input id="vin_input" type="text" placeholder="Masukkan nomor VIN kendaraan Anda..." class="track-input">
                <button onclick="var v=document.getElementById('vin_input').value.trim();if(v)window.location='/track/'+v;" class="btn-primary">LACAK SEKARANG →</button>
            </div>
            <p class="track-hint">
                Nomor VIN terdiri dari 17 karakter dan tertera di STNK, dashboard kendaraan, atau dokumen pembelian.
                <br>Contoh: <strong>MHFXX00G0M0000001</strong>
            </p>
            @auth
            <div class="track-own-vehicle" style="margin-top:2rem;text-align:center">
                <p style="color:var(--text-m);font-size:0.85rem;margin-bottom:1rem">— atau —</p>
                <a href="{{ route('dashboard') }}" class="btn-sm outline">LIHAT KENDARAAN SAYA DI DASBOR</a>
            </div>
            @endauth
        </div>

        @else
        <!-- HASIL PELACAKAN -->
        <div class="track-header">
            <div>
                <p class="eyebrow">STATUS LAYANAN AKTIF</p>
                <h2>{{ $vehicle->brand }} {{ $vehicle->model }} {{ $vehicle->year }}</h2>
                <p class="vin-tag">VIN: {{ $vehicle->vin }} &nbsp;·&nbsp; Plat: {{ $vehicle->license_plate }}</p>
            </div>
            @if($booking)
            <div class="track-meta">
                <div class="track-meta-item">
                    <span>KODE PEMESANAN</span>
                    <strong>{{ $booking->booking_code }}</strong>
                </div>
                <div class="track-meta-item">
                    <span>JENIS LAYANAN</span>
                    <strong>{{ $booking->service_type }}</strong>
                </div>
                <div class="track-meta-item">
                    <span>TANGGAL SERVIS</span>
                    <strong>{{ $booking->service_date->format('d M Y') }}</strong>
                </div>
                <div class="track-meta-item">
                    <span>STATUS</span>
                    <span class="badge {{ $booking->status_badge }}">{{ strtoupper(str_replace('_', ' ', $booking->status)) }}</span>
                </div>
                @if($booking->estimated_finish)
                <div class="track-meta-item">
                    <span>PERKIRAAN SELESAI</span>
                    <strong>{{ \Carbon\Carbon::parse($booking->estimated_finish)->format('d M Y, H:i') }}</strong>
                </div>
                @endif
                @if($booking->invoice)
                <div class="track-meta-item">
                    <span>FAKTUR</span>

                    <a href="{{ route('invoice.show', $booking->invoice->id) }}"
                    class="hbtn hbtn-primary"
                    style="margin-top:.4rem;display:inline-flex;font-size:.75rem">
                        LIHAT INVOICE
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>

        @if($booking)
        <!-- TAHAP KEMAJUAN -->
        <div class="stages-wrap">
            <div class="stages-progress-bar">
                <div class="stages-fill" style="width: {{ $booking->progress }}%"></div>
            </div>
            <p class="stages-pct-label">Kemajuan: <strong>{{ $booking->progress }}%</strong></p>

            <div class="stages-list">
                @php $progressPct = $booking->progress; @endphp
                @foreach($stages as $i => $stage)
                @php
                    $threshold = ($i + 1) * 20;
                    if ($booking->status === 'cancelled') {
                    $stageStatus = ($i === count($stages) - 1)
                        ? 'completed'
                        : 'completed';
                    } else {
                    $stageStatus = $progressPct >= $threshold
                        ? 'completed'
                        : ($progressPct >= $threshold - 20
                            ? 'active'
                            : 'pending');
                }
                @endphp
                <div class="stage-item {{ $stageStatus }}">
                    <div class="stage-dot">
                        @if($stageStatus === 'completed') ✓
                        @elseif($stageStatus === 'active') ●
                        @else {{ $i + 1 }}
                        @endif
                    </div>
                    <div class="stage-info">
                        <h4>{{ $stage['name'] }}</h4>
                        <p>
                        @if($booking->status === 'cancelled')
                            Booking dibatalkan
                        @elseif($stageStatus === 'completed')
                            Selesai
                        @elseif($stageStatus === 'active')
                            Sedang berlangsung
                        @else
                            Menunggu giliran
                        @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($booking->admin_notes)
        <!-- CATATAN TEKNISI -->
        <div class="track-notes-card">
            <p class="card-eyebrow">CATATAN DARI TEKNISI</p>
            <p class="track-notes-text">{{ $booking->admin_notes }}</p>
        </div>
        @endif

        <!-- INFO SPESIALIS — Real-time dari handled_by admin -->
        <div class="track-specialist">
            @php
                $techName = $booking->handled_by ?? $booking->specialist ?? null;
                $initials = $techName
                    ? collect(explode(' ', $techName))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->join('')
                    : '?';
            @endphp
            <div class="specialist-info">
                <div class="specialist-avatar {{ $techName ? 'specialist-avatar-active' : 'specialist-avatar-empty' }}">
                    {{ $initials }}
                </div>
                <div>
                    <p class="eyebrow">TEKNISI YANG MENANGANI</p>
                    @if($techName)
                        <h3>{{ $techName }}</h3>
                        <p>Teknisi Resmi Carvix</p>
                        <span class="specialist-status-dot">● Sedang aktif menangani kendaraan Anda</span>
                    @else
                        <h3 style="color:var(--text-m)">Belum Ditugaskan</h3>
                        <p>Menunggu penugasan teknisi oleh admin</p>
                        <span class="specialist-status-pending">● Pesanan sedang menunggu konfirmasi</span>
                    @endif
                </div>
            </div>
            <a href="{{ route('booking') }}" class="btn-outline">PESAN LAYANAN LAIN</a>
        </div>

        @else
        <div class="no-booking">
            <div class="no-booking-icon">🔍</div>
            <h3>Tidak Ada Pesanan Aktif</h3>
            <p>Tidak ditemukan pesanan aktif untuk kendaraan dengan VIN <strong>{{ $vehicle->vin }}</strong>.</p>
            <div style="display:flex;gap:1rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap">
                <a href="{{ route('booking') }}" class="btn-primary">Pesan Layanan Sekarang</a>
                <a href="{{ route('track') }}" class="btn-outline">Lacak VIN Lain</a>
            </div>
        </div>
        @endif

        @endif
    </div>
</section>

@endsection
