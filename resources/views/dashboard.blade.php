@extends('layouts.app')
@section('title', 'Dasbor — Skensa Auto Service')

@section('content')

<section class="dashboard-section">
    <div class="container">

        <div class="dashboard-header">
            <div>
                <p class="eyebrow">SELAMAT KEMBALI</p>
                <h1>{{ Auth::user()->name }}</h1>
                <p class="dash-sub">
                    @if($vehicle)
                        Pemantauan presisi untuk {{ $vehicle->year }} {{ $vehicle->brand }} {{ $vehicle->model }}
                    @else
                        Selamat datang di panel Skensa Auto Service Anda
                    @endif
                </p>
                @if($vehicle)
                    <p class="vin-tag">VIN: {{ $vehicle->vin }} &nbsp;·&nbsp; Plat: {{ $vehicle->license_plate }}</p>
                @endif
            </div>
            <div class="dash-stats">
                <div class="dash-stat-card">
                    <span class="stat-val">{{ $stats['total_bookings'] }}</span>
                    <span class="stat-lbl">Total Pemesanan</span>
                </div>
                <div class="dash-stat-card">
                    <span class="stat-val">{{ $stats['completed'] }}</span>
                    <span class="stat-lbl">Selesai</span>
                </div>
                <div class="dash-stat-card">
                    <span class="stat-val">{{ $stats['in_progress'] }}</span>
                    <span class="stat-lbl">Sedang Berjalan</span>
                </div>
            </div>
        </div>

        @if(!$vehicle)
        <!-- STATE KOSONG — belum ada kendaraan -->
        <div class="dash-empty-state">
            <h3>Belum Ada Kendaraan Terdaftar</h3>
            <p>Buat pemesanan pertama Anda untuk mendaftarkan kendaraan dan mulai memantau status servis secara real-time.</p>
            <a href="{{ route('booking') }}" class="hbtn hbtn-primary" style="display:inline-flex;margin-top:1.5rem">Pesan Layanan Pertama</a>
        </div>
        @else

        <div class="dashboard-grid">

            <!-- KARTU KENDARAAN -->
            <div class="dash-card vehicle-card">
                <div class="card-header">
                    <h3>{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                    <span class="badge badge-success">Terdaftar</span>
                </div>
                <div class="vehicle-specs">
                    <div class="spec-item">
                        <span class="spec-label">Tahun</span>
                        <span class="spec-val">{{ $vehicle->year }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Plat Nomor</span>
                        <span class="spec-val">{{ $vehicle->license_plate }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Jarak Tempuh</span>
                        <span class="spec-val">{{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Pemilik</span>
                        <span class="spec-val">{{ $vehicle->owner_name }}</span>
                    </div>
                </div>
                
                <a href="{{ route('track.show', $vehicle->vin) }}" class="btn-sm mt-4">Lacak Kendaraan</a>

                @if ($vehicles->count() > 1)
                <button type="button"
                        onclick="toggleVehicles()"
                        class="btn-sm mt-4">
                    Lihat Kendaraan Lain ({{ $vehicles->count() - 1 }})
                </button>
                @endif

                <div id="otherVehicles"
                    style="display:none;margin-top:1rem;border-top:1px solid #eee;padding-top:1rem">

                    @foreach($vehicles as $v)
                        @if($v->id !== $vehicle->id)
                        <div style="padding:.8rem;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:.7rem">
                            <strong>{{ $v->brand }} {{ $v->model }}</strong><br>
                            <small>{{ $v->license_plate }}</small>

                            <div style="margin-top:.6rem">
                                <a href="{{ route('track.show', $v->vin) }}"
                                style="font-size:.85rem;color:var(--yellow-dark);text-decoration:none;font-weight:600">
                                    Lacak Kendaraan
                                </a>
                            </div>
                        </div>
                        @endif
                    @endforeach

                </div>

                <script>
                function toggleVehicles() {
                    const el = document.getElementById('otherVehicles');
                    el.style.display = el.style.display === 'none' ? 'block' : 'none';
                }
                </script>
                
            </div>

            <!-- SPESIALIS DITUGASKAN — Real-time dari handled_by admin -->
            <div class="dash-card specialist-card">
                <p class="card-eyebrow">SPESIALIS DITUGASKAN</p>
                @if($activeBooking && ($activeBooking->handled_by || $activeBooking->specialist))
                    @php
                        $techName = $activeBooking->handled_by ?? $activeBooking->specialist;
                        $initials = collect(explode(' ', $techName))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->join('');
                    @endphp
                    <div class="specialist-info">
                        <div class="specialist-avatar specialist-avatar-active">{{ $initials }}</div>
                        <div>
                            <h3>{{ $techName }}</h3>
                            <p class="specialist-role">TEKNISI AKTIF</p>
                            <span class="specialist-status-dot">● Sedang menangani kendaraan Anda</span>
                        </div>
                    </div>
                    @if($activeBooking->admin_notes)
                    <div class="specialist-notes">
                        <p class="spec-notes-label">CATATAN TEKNISI:</p>
                        <p class="spec-notes-text">{{ $activeBooking->admin_notes }}</p>
                    </div>
                    @endif
                    @if($activeBooking->estimated_finish)
                    <div class="specialist-eta">
                        <span class="eta-label">Estimasi Selesai:</span>
                        <span class="eta-val">{{ \Carbon\Carbon::parse($activeBooking->estimated_finish)->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                @else
                    <div class="specialist-info">
                        <div class="specialist-avatar specialist-avatar-empty">?</div>
                        <div>
                            <h3 style="color:var(--text-m)">Belum Ditugaskan</h3>
                            <p class="specialist-role">Menunggu konfirmasi admin</p>
                            <span class="specialist-status-pending">Pesanan sedang diproses</span>
                        </div>
                    </div>
                    <p class="specialist-hint">Teknisi akan ditugaskan setelah admin mengkonfirmasi pesanan Anda.</p>
                @endif
                <div class="card-actions" style="margin-top:1.2rem">
                    @if($activeBooking)
                        <a href="{{ route('track.show', $vehicle->vin) }}" class="btn-sm">LACAK LANGSUNG</a>
                    @else
                        <a href="{{ route('booking') }}" class="btn-sm">BUAT PESANAN</a>
                    @endif
                    <a href="{{ route('history') }}" class="btn-sm outline">RIWAYAT</a>
                </div>
            </div>

            <!-- LAYANAN AKTIF -->
            <div class="dash-card active-service-card">
                <div class="card-header">
                    <p class="card-eyebrow">LAYANAN AKTIF</p>
                    @if($activeBooking)
                        <span class="badge {{ $activeBooking->status_badge }}">{{ strtoupper(str_replace('_',' ',$activeBooking->status)) }}</span>
                    @else
                        <span class="badge badge-secondary">TIDAK ADA</span>
                    @endif
                </div>
                @if($activeBooking)
                    <h3>{{ $activeBooking->service_type }}</h3>
                    <p style="font-size:0.82rem;color:var(--text-m);margin-bottom:1rem">
                        Kode: <strong>{{ $activeBooking->booking_code }}</strong> &nbsp;·&nbsp;
                        Tanggal: <strong>{{ $activeBooking->service_date->format('d M Y') }}</strong>
                    </p>
                    <div class="progress-wrap">
                        <div class="progress-label">
                            <span>KEMAJUAN SERVIS</span>
                            <span>{{ $activeBooking->progress ?? 0 }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $activeBooking->progress ?? 0 }}%"></div>
                        </div>
                    </div>
                    @if($activeBooking->service_cost)
                    <div class="active-service-cost">
                        <span>Estimasi Biaya:</span>
                        <strong>Rp {{ number_format($activeBooking->service_cost, 0, ',', '.') }}</strong>
                    </div>
                    @endif
                    <a href="{{ route('track.show', $vehicle->vin) }}" class="btn-sm mt-2">LACAK LANGSUNG →</a>
                @else
                    <div class="no-active-service">
                        <p>Tidak ada layanan aktif saat ini.</p>
                        <a href="{{ route('booking') }}" class="btn-sm" style="margin-top:0.8rem">PESAN LAYANAN</a>
                    </div>
                @endif
            </div>

            <!-- LOG LAYANAN -->
            <div class="dash-card log-card">
                <p class="card-eyebrow">LOG AKTIVITAS TERBARU</p>
                <div class="log-list">
                    @if($activeBooking)
                    <div class="log-item">
                        <span class="log-icon">🔧</span>
                        <div>
                            <p>{{ $activeBooking->service_type }}</p>
                            <small>Status: {{ ucfirst(str_replace('_', ' ', $activeBooking->status)) }} · {{ $activeBooking->created_at->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('track.show', $vehicle->vin) }}" class="btn-sm outline" style="font-size:0.7rem;padding:0.3rem 0.7rem">Lacak</a>
                    </div>
                    @endif
                    @if($activeBooking?->invoice)
                    <div class="log-item">
                        <div>
                            <p>Faktur #{{ $activeBooking->invoice->invoice_number }}</p>
                            <small>{{ ucfirst($activeBooking->invoice->payment_status) }} · Rp {{ number_format($activeBooking->invoice->total, 0, ',', '.') }}</small>
                        </div>
                        <a href="{{ route('invoice.show', $activeBooking->invoice->id) }}" class="btn-sm outline" style="font-size:0.7rem;padding:0.3rem 0.7rem">Lihat</a>
                    </div>
                    @endif
                    <div class="log-item">
                        <div>
                            <p>Total Servis: {{ $stats['total_bookings'] }} kali</p>
                            <small>{{ $stats['completed'] }} selesai · {{ $stats['in_progress'] }} berjalan</small>
                        </div>
                    </div>
                    @if($stats['total_bookings'] === 0)
                    <div class="log-item log-empty">
                        <div><p>Belum ada riwayat layanan</p><small>Buat pemesanan pertama Anda</small></div>
                    </div>
                    @endif
                </div>
                <a href="{{ route('history') }}" class="btn-sm mt-2">LIHAT RIWAYAT LENGKAP →</a>
            </div>

        </div>
        @endif
    </div>
</section>

@endsection
