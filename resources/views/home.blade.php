@extends('layouts.app')
@section('title', 'Skensa Auto Service')

@section('content')

    {{-- Cek tagihan belum lunas milik user yang login --}}
    @php
        $pendingInvoice = null;
        if (auth()->check()) {
            $pendingInvoice = \App\Models\Invoice::whereHas('booking.vehicle', function ($q) {
                $q->where('user_id', auth()->id())->orWhere('email', auth()->user()->email);
            })
                ->where('payment_status', 'unpaid')
                ->with('booking.vehicle')
                ->latest()
                ->first();
        }
    @endphp

    <!-- ══════════════════════════════════════════
                             HERO SECTION
                        ══════════════════════════════════════════ -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-inner">
            <div class="hero-left">

                <h1 class="hero-heading">
                    Sistem Service Kendaraan Digital <br>
                    <span class="hero-accent">Skensa Auto Service</span>
                </h1>

                <p class="hero-desc">
                    Dengan Skensa Auto Service, Anda dapat melihat perkembangan service kendaraan secara langsung,
                    mendapatkan informasi yang jelas, serta menikmati proses perawatan kendaraan yang lebih praktis dan
                    transparan.
                </p>
                <div class="hero-btns">
                    <a href="{{ route('booking') }}" class="hbtn hbtn-primary">
                        Pesan Layanan →
                    </a>

                    <a href="{{ route('services') }}" class="hbtn hbtn-ghost">
                        Lihat Layanan
                    </a>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-visual">

                    <img src="{{ asset('images/hero-car.jpeg') }}" alt="Skensa Auto Service" class="hero-image">

                    <div class="floating-card">
                        <span class="floating-number">500+</span>
                        <p>Kendaraan Telah Diservis</p>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════
                             MODULES SECTION
                        ══════════════════════════════════════════ -->
    <section class="modules-section">
        <div class="modules-inner">

            <div class="modules-header">
                <div>
                    <h2 class="modules-title">Kontrol Presisi di Ujung Jari Anda</h2>
                    <p class="modules-sub">Setiap tonggak layanan ditangkap dan dilacak dalam ekosistem digital aman kami.
                    </p>
                </div>
                <div class="modules-stat">
                    <span class="modules-stat-num">99.8%</span>
                    <span class="modules-stat-label">TINGKAT KEPUASAN</span>
                </div>
            </div>

            <div class="modules-cards">
                <div class="mod-card mod-card-large">
                    <div class="mod-card-top">
                    </div>
                    <h3>Pemesanan Lancar</h3>
                    <p>Penjadwalan intuitif dengan konfirmasi instan. Pilih jenis layanan, tanggal, dan dapatkan kode
                        booking dalam hitungan detik.</p>
                    <a href="{{ route('booking') }}" class="mod-link">PESAN SEKARANG →</a>
                </div>
                <div class="mod-card">
                    <div class="mod-card-top">
                    </div>
                    <h3>Pelacakan Langsung</h3>
                    <p>Pantau setiap tahap servis kendaraan Anda secara real-time — dari penerimaan hingga penyerahan.</p>
                    <a href="{{ route('track') }}" class="mod-link">LACAK SEKARANG →</a>
                    <div class="mod-bar"></div>
                </div>
                <div class="mod-card">
                    <div class="mod-card-top">
                    </div>
                    <h3>Riwayat Layanan</h3>
                    <p>Buku besar digital lengkap dari setiap servis, penggantian suku cadang, dan catatan diagnostik
                        kendaraan Anda.</p>
                    @auth
                        <a href="{{ route('history') }}" class="mod-link">LIHAT RIWAYAT →</a>
                    @else
                        <a href="{{ route('login') }}" class="mod-link">MASUK UNTUK LIHAT →</a>
                    @endauth

                </div>
            </div>

            <!-- ══════════════════════════════════════════
                                     INVOICE ROW
                                     - Ada tagihan unpaid  → 2 kolom (kiri + preview faktur kanan)
                                     - Tidak ada / sudah lunas → kiri full width
                                ══════════════════════════════════════════ -->
            <div class="invoice-row {{ !$pendingInvoice ? 'invoice-row-fullwidth' : '' }}">

                {{-- KIRI — selalu tampil --}}
                <div class="invoice-row-left">
                    <h3>Penagihan Transparan & Digital</h3>
                    <p>Tidak ada biaya tersembunyi. Setiap layanan tercatat dengan rincian lengkap — suku cadang, biaya
                        jasa, dan pajak ditampilkan secara jelas. Faktur digital diterbitkan otomatis setelah layanan
                        selesai dan bisa diunduh kapan saja.</p>

                    <div class="invoice-features-list">
                        <div class="inv-feature-item">
                            <span class="inv-feature-icon">✓</span>
                            <span>Rincian biaya lengkap & transparan</span>
                        </div>
                        <div class="inv-feature-item">
                            <span class="inv-feature-icon">✓</span>
                            <span>Faktur PDF bisa diunduh & dicetak</span>
                        </div>
                        <div class="inv-feature-item">
                            <span class="inv-feature-icon">✓</span>
                            <span>Riwayat pembayaran tersimpan otomatis</span>
                        </div>
                        <div class="inv-feature-item">
                            <span class="inv-feature-icon">✓</span>
                            <span>Notifikasi status pembayaran real-time</span>
                        </div>
                    </div>

                    <div class="invoice-stats">
                        <div class="inv-stat">
                            <span class="inv-stat-val">Instan</span>
                            <span class="inv-stat-lbl">PENERBITAN FAKTUR</span>
                        </div>
                        <div class="inv-stat">
                            <span class="inv-stat-val">100%</span>
                            <span class="inv-stat-lbl">DIGITAL & AMAN</span>
                        </div>
                        <div class="inv-stat">
                            <span class="inv-stat-val">0</span>
                            <span class="inv-stat-lbl">BIAYA TERSEMBUNYI</span>
                        </div>
                    </div>


                </div>

                {{-- KANAN — hanya muncul jika ada tagihan belum lunas --}}
                @if ($pendingInvoice)
                    <div class="invoice-row-right">
                        <div class="inv-preview-enhanced">

                            <div class="inv-preview-top">
                                <span
                                    style="color:var(--dark);font-weight:800;font-family:var(--font-d);font-size:.85rem;letter-spacing:.05em">
                                    Skensa Auto Service
                                </span>
                                <span
                                    style="font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:999px;background:#fef3c7;color:#92400e;border:1px solid #fde68a">
                                    BELUM LUNAS
                                </span>
                            </div>

                            <div class="inv-preview-title">
                                <p class="inv-num">{{ $pendingInvoice->invoice_number }}</p>
                                <p class="inv-date">Diterbitkan:
                                    {{ \Carbon\Carbon::parse($pendingInvoice->issue_date)->format('d M Y') }}</p>
                            </div>

                            <div class="inv-preview-customer">
                                <p><strong>Pelanggan:</strong> {{ $pendingInvoice->booking->vehicle->owner_name }}</p>
                                <p><strong>Kendaraan:</strong>
                                    {{ $pendingInvoice->booking->vehicle->year }}
                                    {{ $pendingInvoice->booking->vehicle->brand }}
                                    {{ $pendingInvoice->booking->vehicle->model }}
                                </p>
                            </div>

                            <div class="inv-preview-items">
                                @forelse($pendingInvoice->items ?? [] as $item)
                                    <div class="inv-item-row">
                                        <span class="inv-item-name">{{ $item['description'] }}</span>
                                        <span class="inv-item-price">Rp
                                            {{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <div class="inv-item-row">
                                        <span class="inv-item-name">{{ $pendingInvoice->booking->service_type }}</span>
                                        <span class="inv-item-price">Rp
                                            {{ number_format($pendingInvoice->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforelse
                            </div>

                            <div class="inv-preview-subtotals">
                                <div class="inv-subtotal-row">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($pendingInvoice->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="inv-subtotal-row">
                                    <span>Pajak (11%)</span>
                                    <span>Rp {{ number_format($pendingInvoice->tax, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="inv-preview-total">
                                <span>TOTAL TAGIHAN</span>
                                <span class="inv-total-amount">Rp
                                    {{ number_format($pendingInvoice->total, 0, ',', '.') }}</span>
                            </div>

                            {{-- Jatuh tempo --}}
                            @if (\Carbon\Carbon::parse($pendingInvoice->due_date)->isPast())
                                <p
                                    style="font-size:.72rem;color:#dc2626;font-weight:700;margin-bottom:.75rem;text-align:center;background:#fee2e2;padding:.4rem;border-radius:6px">
                                    Melewati jatuh tempo:
                                    {{ \Carbon\Carbon::parse($pendingInvoice->due_date)->format('d M Y') }}
                                </p>
                            @else
                                <p style="font-size:.72rem;color:#92400e;margin-bottom:.75rem;text-align:center">
                                    Jatuh tempo:
                                    <strong>{{ \Carbon\Carbon::parse($pendingInvoice->due_date)->format('d M Y') }}</strong>
                                </p>
                            @endif

                            <div class="inv-preview-actions">
                                <a href="{{ route('invoice.show', $pendingInvoice->id) }}" class="inv-action-btn">
                                    Lihat & Bayar →
                                </a>
                                <a href="{{ route('history') }}" class="inv-action-btn outline">
                                    Riwayat
                                </a>
                            </div>

                        </div>
                    </div>
                @endif

            </div>{{-- end invoice-row --}}

        </div>
    </section>

    <!-- ══════════════════════════════════════════
                             HERITAGE SECTION
                        ══════════════════════════════════════════ -->
    <section class="heritage-section">
        <div class="heritage-inner">
            <div class="heritage-img-wrap">
                <div class="heritage-img">
                    <div class="heritage-img-overlay"></div>
                    <!-- IMAGE SLIDER -->
                    <div class="heritage-slider" id="heritageSlider">
                        <div class="heritage-slider-track" id="heritageSliderTrack">
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide1.jpg') }}"
                                    alt="Skensa Auto Service Workshop 1" loading="lazy"></div>
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide2.jpg') }}"
                                    alt="Skensa Auto Service Workshop 2" loading="lazy"></div>
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide3.jpg') }}"
                                    alt="Skensa Auto Service Workshop 3" loading="lazy"></div>
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide4.jpg') }}"
                                    alt="Skensa Auto Service Workshop 4" loading="lazy"></div>
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide5.jpg') }}"
                                    alt="Skensa Auto Service Workshop 5" loading="lazy"></div>
                            <div class="heritage-slide"><img src="{{ asset('images/gallery/slide6.jpg') }}"
                                    alt="Skensa Auto Service Workshop 6" loading="lazy"></div>
                        </div>
                        <div class="heritage-slider-dots" id="heritageSliderDots"></div>
                    </div>
                    <div class="heritage-stats-overlay">
                        <div class="h-stat">
                            <span class="h-stat-num">150+</span>
                            <span class="h-stat-lbl">BENGKEL MITRA</span>
                        </div>
                        <div class="h-stat">
                            <span class="h-stat-num">50K+</span>
                            <span class="h-stat-lbl">SERVIS SELESAI</span>
                        </div>
                        <div class="h-stat">
                            <span class="h-stat-num">98%</span>
                            <span class="h-stat-lbl">KEPUASAN PELANGGAN</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="heritage-text">
                <p class="heritage-eyebrow">TENTANG Skensa Auto Service</p>
                <h2 class="heritage-heading">
                    Dirancang untuk Era<br>
                    Digital, Dibangun di atas<br>
                    Keahlian Mekanik.
                </h2>
                <p class="heritage-desc">
                    Skensa Auto Service dikembangkan untuk membantu proses layanan bengkel menjadi lebih terstruktur dan
                    mudah diakses. Dengan memanfaatkan teknologi digital, Skensa Auto Service memudahkan pelanggan dan pihak
                    bengkel dalam mengelola informasi service kendaraan.
                </p>
                <p class="heritage-desc">
                    Dengan Skensa Auto Service, pelanggan dapat memantau perkembangan service kendaraan serta melihat
                    informasi yang dibutuhkan tanpa harus datang langsung ke bengkel.
                </p>
                <div class="heritage-cta">
                    <a href="{{ route('services') }}" class="hbtn hbtn-primary">LIHAT SEMUA LAYANAN</a>
                    <a href="{{ route('booking') }}" class="hbtn hbtn-ghost">PESAN SEKARANG</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════
                             TRACK CTA SECTION
                        ══════════════════════════════════════════ -->
    <section class="track-cta-section">
        <div class="track-cta-inner">
            <div class="track-cta-left">
                <p class="hero-eyebrow" style="color:var(--yellow)">LACAK KENDARAAN ANDA</p>
                <h2>Pantau Status Servis<br>Secara <span style="color:var(--yellow)">Real-Time</span></h2>
                <p style="color:var(--text-m);margin-top:0.75rem">
                    Masukkan nomor VIN kendaraan Anda dan lihat langsung di tahap mana kendaraan Anda sedang diservisi.
                </p>
            </div>
            <div class="track-cta-right">
                <div class="track-cta-form">
                    <input type="text" id="homVin" placeholder="Masukkan nomor VIN..." class="track-input-home"
                        style="color:var(--text-m);">
                    <button
                        onclick="var v=document.getElementById('homVin').value.trim();if(v)window.location='/track/'+v;else window.location='{{ route('track') }}'"
                        class="track-cta-btn">
                        LACAK SEKARANG →
                    </button>
                </div>
                <p style="font-size:.75rem;color:var(--text-m);margin-top:.75rem">
                    Ingin cek status tanpa VIN?
                    <a href="{{ route('track') }}" style="color:var(--yellow)">Klik di sini</a>
                </p>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        (function() {
            const track = document.getElementById('heritageSliderTrack');
            const dotsWrap = document.getElementById('heritageSliderDots');
            if (!track || !dotsWrap) return;

            const slides = track.querySelectorAll('.heritage-slide');
            const total = slides.length;
            let current = 0;
            let timer = null;

            // Build dots
            slides.forEach(function(_, i) {
                const dot = document.createElement('button');
                dot.className = 'heritage-slider-dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Slide ' + (i + 1));
                dot.addEventListener('click', function() {
                    goTo(i);
                    resetTimer();
                });
                dotsWrap.appendChild(dot);
            });

            function goTo(index) {
                current = (index + total) % total;
                track.style.transform = 'translateX(-' + (current * 100) + '%)';
                dotsWrap.querySelectorAll('.heritage-slider-dot').forEach(function(d, i) {
                    d.classList.toggle('active', i === current);
                });
            }

            function next() {
                goTo(current + 1);
            }

            function resetTimer() {
                clearInterval(timer);
                timer = setInterval(next, 4000);
            }

            // Pause on hover
            var slider = document.getElementById('heritageSlider');
            if (slider) {
                slider.addEventListener('mouseenter', function() {
                    clearInterval(timer);
                });
                slider.addEventListener('mouseleave', resetTimer);
            }

            // Swipe support
            var touchStartX = 0;
            track.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
            }, {
                passive: true
            });
            track.addEventListener('touchend', function(e) {
                var diff = touchStartX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 40) {
                    goTo(diff > 0 ? current + 1 : current - 1);
                    resetTimer();
                }
            }, {
                passive: true
            });

            resetTimer();
        })();
    </script>
@endpush
