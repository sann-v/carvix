@extends('layouts.app')
@section('title', 'Layanan Kami')

@section('content')

<section class="page-hero">
    <div class="page-hero-content">
        <p class="hero-eyebrow">APA YANG KAMI TAWARKAN</p>
        <h1>Layanan <span class="accent">Presisi</span></h1>
        <p>Perawatan otomotif berperforma tinggi yang dirancang untuk mesin modern.</p>
    </div>
</section>

<section class="services-page" style="padding: 4rem;">
    <div class="container">

        <div class="features-grid">

            <div class="feature-card">
                <p class="feature-module">LAYANAN 01</p>
                <h3>Diagnostik Lengkap</h3>
                <p>Pemindaian sistem lengkap dengan presisi spek OEM. Laporan DME, toleransi rem, dan pemeriksaan viskositas cairan.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

            <div class="feature-card featured">
                <p class="feature-module">LAYANAN 02</p>
                <h3>Pemeliharaan Penuh</h3>
                <p>Inspeksi kinerja tahunan mencakup mesin, transmisi, suspensi, dan semua sistem kritis.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

            <div class="feature-card">
                <p class="feature-module">LAYANAN 03</p>
                <h3>Layanan Mesin</h3>
                <p>Kalibrasi mesin presisi, layanan sistem oli, dan penyetelan performa oleh spesialis bersertifikat.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

            <div class="feature-card">
                <p class="feature-module">LAYANAN 04</p>
                <h3>Layanan Rem</h3>
                <p>Inspeksi sistem rem lengkap, penggantian kampas, penggerindaan rotor, dan flush cairan.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

            <div class="feature-card">
                <p class="feature-module">LAYANAN 05</p>
                <h3>Upgrade Performa Apex</h3>
                <p>Upgrade performa Tahap 1-3 termasuk remap ECU, knalpot, intake, dan penyetelan suspensi.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

            <div class="feature-card">
                <p class="feature-module">LAYANAN 06</p>
                <h3>Suspensi & Penyelarasan</h3>
                <p>Pemeriksaan geometri suspensi lengkap, penyetelan coilover, dan penyelarasan roda presisi untuk penanganan optimal.</p>
                <a href="{{ route('booking') }}" class="btn-primary" style="font-size:0.75rem; padding: 0.6rem 1.2rem;">PESAN SEKARANG</a>
            </div>

        </div>

    </div>
</section>

@endsection