@extends('layouts.app')
@section('title', 'Masuk ke Akun')

@section('content')

    <section class="auth-section">
        <div class="auth-container">

            <div class="auth-card">
                <div class="auth-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Carvix Logo" class="logo-icon large">
                    <span class="logo-text" style="font-size:1.3rem">Skensa Auto Service</span>
                </div>

                <h1 class="auth-title">Selamat Datang Kembali</h1>
                <p class="auth-sub">Masuk untuk memantau kendaraan dan riwayat layanan Anda</p>

                @if($errors->any())
                    <div class="auth-alert-error">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label>ALAMAT EMAIL</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required
                            autofocus>
                    </div>

                    <div class="auth-field">
                        <label>PASSWORD</label>
                        <div class="input-password-wrap">
                            <input type="password" name="password" id="passwordInput" placeholder="Minimal 8 karakter"
                                required>
                            <button type="button" class="toggle-pwd" onclick="togglePassword()">
                                <svg id="eyeIcon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" stroke="currentColor"
                                        stroke-width="1.3" />
                                    <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="auth-remember">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span class="chekbox-text">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="auth-btn">MASUK →</button>
                </form>

                <p class="auth-switch">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar sekarang</a>
                </p>

                <!-- Tambahkan ini -->
                <p class="auth-switch" style="margin-top:0.5rem;opacity:0.5;font-size:0.75rem">
                    Karyawan? <a href="{{ route('admin.login') }}">Login Admin</a>
                </p>
            </div>

            <!-- Decorative side -->
            <div class="auth-deco">
                <div class="auth-deco-content">
                    <p class="deco-label">SISTEM TERPADU</p>
                    <h2>Kendali Penuh<br>Kendaraan Anda</h2>
                    <div class="deco-features">
                        <div class="deco-feat">
                            <span class="deco-dot"></span>
                            <span>Pelacakan layanan real-time</span>
                        </div>
                        <div class="deco-feat">
                            <span class="deco-dot"></span>
                            <span>Riwayat perawatan lengkap</span>
                        </div>
                        <div class="deco-feat">
                            <span class="deco-dot"></span>
                            <span>Invoice digital instan</span>
                        </div>
                        <div class="deco-feat">
                            <span class="deco-dot"></span>
                            <span>Notifikasi status langsung</span>
                        </div>
                    </div>
                    <div class="deco-stat">
                        <span class="deco-num">10.000+</span>
                        <span class="deco-lbl">Pengguna Aktif</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

@endsection
