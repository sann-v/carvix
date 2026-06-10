@extends('layouts.app')
@section('title', 'Pemesanan Layanan Presisi')

@section('content')

<section class="page-hero">
    <div class="page-hero-content">
        <p class="hero-eyebrow">OTORISASI PROTOKOL · CRVX-8829-PRCSN</p>
        <h1>Pemesanan<br><span class="accent">Layanan Presisi</span></h1>
        <p>
            Jaga integritas mesin Anda. Insinyur kami menyediakan diagnostik
            presisi dan keahlian profesional untuk sistem otomotif berperforma tinggi.
        </p>
    </div>
</section>

<section class="booking-section">
    <div class="container">

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
            @csrf

            <!-- IDENTITAS PEMILIK -->
            <div class="form-block">
                <h3 class="form-block-title">
                    <span class="block-num">01</span> IDENTITAS PEMILIK
                </h3>

                <div class="form-grid-2">

                    <div class="form-group">
                        <label>NAMA LENGKAP</label>
                        <input type="text"
                               name="owner_name"
                               placeholder="CONTOH: JULIAN BLACKWOOD"
                               value="{{ old('owner_name', $user?->name ?? '') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>ALAMAT EMAIL</label>
                        <input type="email"
                               name="email"
                               placeholder="pemilik@contoh.com"
                               value="{{ old('email', $user?->email ?? '') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>NOMOR TELEPON</label>
                        <input type="text"
                               name="phone"
                               placeholder="+62 8XX XXXX XXXX"
                               value="{{ old('phone', $user?->phone ?? '') }}">
                    </div>

                </div>
            </div>

            <!-- SPESIFIKASI MESIN -->
            <div class="form-block">
                <h3 class="form-block-title">
                    <span class="block-num">02</span> SPESIFIKASI MESIN
                </h3>

                <div class="form-grid-2">

                    <div class="form-group">
                        <label>MEREK KENDARAAN</label>
                        <input type="text"
                               name="vehicle_brand"
                               placeholder="Porsche, Audi, dll."
                               value="{{ old('vehicle_brand') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>MODEL / TIPE</label>
                        <input type="text"
                               name="vehicle_model"
                               placeholder="911 Carrera, RS6, dll."
                               value="{{ old('vehicle_model') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>TAHUN PEMBUATAN</label>
                        <input type="number"
                               name="year"
                               placeholder="2024"
                               min="1990"
                               max="{{ date('Y') + 1 }}"
                               value="{{ old('year') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>PLAT NOMOR</label>
                        <input type="text"
                               name="license_plate"
                               placeholder="ABC-1234"
                               value="{{ old('license_plate') }}"
                               required>
                    </div>

                    <div class="form-group span-2">
                        <label>VIN (Opsional)</label>
                        <input type="text"
                               name="vin"
                               placeholder="Biarkan kosong untuk auto-generate"
                               value="{{ old('vin') }}">
                    </div>

                </div>
            </div>

            <!-- JADWAL & DESKRIPSI MASALAH -->
            <div class="form-block">
                <h3 class="form-block-title">
                    <span class="block-num">03</span> JADWAL & DESKRIPSI MASALAH
                </h3>

                <div class="form-grid-2">

                    <div class="form-group">
                        <label>JENIS LAYANAN</label>

                        <select name="service_type" required>
                            <option value="">Pilih layanan...</option>

                            <option value="Full Maintenance"
                                {{ old('service_type') == 'Full Maintenance' ? 'selected' : '' }}>
                                Pemeliharaan Penuh
                            </option>

                            <option value="Diagnostic"
                                {{ old('service_type') == 'Diagnostic' ? 'selected' : '' }}>
                                Inspeksi Diagnostik
                            </option>

                            <option value="Engine Service"
                                {{ old('service_type') == 'Engine Service' ? 'selected' : '' }}>
                                Layanan Mesin
                            </option>

                            <option value="Brake Service"
                                {{ old('service_type') == 'Brake Service' ? 'selected' : '' }}>
                                Layanan Rem
                            </option>

                            <option value="Suspension"
                                {{ old('service_type') == 'Suspension' ? 'selected' : '' }}>
                                Suspensi
                            </option>

                            <option value="Apex Performance Upgrade"
                                {{ old('service_type') == 'Apex Performance Upgrade' ? 'selected' : '' }}>
                                Upgrade Performa Apex
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>TANGGAL SERVICE</label>

                        <input type="date"
                               name="service_date"
                               value="{{ old('service_date') }}"
                               required
                               min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group span-2">
                        <label>KELUHAN / GEJALA</label>

                        <textarea name="complaint"
                                  rows="4"
                                  placeholder="Jelaskan perilaku kendaraan...">{{ old('complaint') }}</textarea>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn-primary btn-large">
                KONFIRMASI PEMESANAN
            </button>

        </form>
    </div>
</section>

@endsection
