@extends('layouts.app')
@section('title', 'Buat Akun')

@section('content')

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-card">
            <div class="auth-brand">
                <span class="logo-icon" style="font-size:1.5rem">◈</span>
                <span class="logo-text" style="font-size:1.3rem">Skensa Auto Service</span>
            </div>

            <h1 class="auth-title">Buat Akun Baru</h1>
            <p class="auth-sub">Bergabung dan nikmati layanan otomotif presisi digital</p>

            @if($errors->any())
                <div class="auth-alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label>NAMA LENGKAP</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Nama sesuai KTP" required autofocus>
                </div>

                <div class="auth-field">
                    <label>ALAMAT EMAIL</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="contoh@email.com" required>
                </div>

                <div class="auth-field">
                    <label>NOMOR TELEPON <span style="opacity:.5;font-size:.7rem">(Opsional)</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           placeholder="+62 8XX XXXX XXXX">
                </div>

                <div class="auth-field">
                    <label>PASSWORD</label>
                    <div class="input-password-wrap">
                        <input type="password" name="password" id="passwordInput"
                               placeholder="Minimal 8 karakter" required>
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.3"/>
                                <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="auth-field">
                    <label>KONFIRMASI PASSWORD</label>
                    <input type="password" name="password_confirmation"
                           placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="auth-btn">BUAT AKUN →</button>
            </form>

            <p class="auth-switch">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>

        <!-- Decorative side -->
        <div class="auth-deco">
            <div class="auth-deco-content">
                <p class="deco-label">GRATIS SELAMANYA</p>
                <h2>Mulai Pantau<br>Kendaraan Anda<br>Sekarang</h2>
                <div class="deco-features">
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Daftar dalam 30 detik</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Akses dasbor lengkap</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Kelola banyak kendaraan</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Notifikasi pemesanan instan</span>
                    </div>
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