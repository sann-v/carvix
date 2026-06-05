@extends('layouts.admin')
@section('title', 'Login Admin')

@section('content')

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-card">
            <div class="auth-brand">
                <span class="logo-icon" style="font-size:1.5rem">◈</span>
                <span class="logo-text" style="font-size:1.3rem">Skensa Auto Service</span>
            </div>

            <div style="display:inline-block;background:var(--yellow-dark)22;color:var(--yellow-dark);
                        font-size:0.7rem;font-weight:700;letter-spacing:.1em;
                        padding:4px 12px;border-radius:999px;margin-bottom:1rem">
                PORTAL KARYAWAN
            </div>

            <h1 class="auth-title">Masuk sebagai Admin</h1>
            <p class="auth-sub">Khusus karyawan dan staf bengkel Skensa Auto Service</p>

            @if($errors->any())
                <div class="auth-alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="auth-alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label>EMAIL KARYAWAN</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="karyawan@Skensa Auto Service.com" required autofocus>
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

                <button type="submit" class="auth-btn">MASUK SEBAGAI ADMIN →</button>
            </form>

            <p class="auth-switch">
                Bukan karyawan?
                <a href="{{ route('login') }}">Login sebagai pelanggan</a>
            </p>
        </div>

        <div class="auth-deco">
            <div class="auth-deco-content">
                <p class="deco-label">PANEL ADMIN</p>
                <h2>Kelola Bengkel<br>Lebih Efisien</h2>
                <div class="deco-features">
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Manajemen booking real-time</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Update status kendaraan</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Kelola invoice & pembayaran</span>
                    </div>
                    <div class="deco-feat">
                        <span class="deco-dot"></span>
                        <span>Laporan layanan harian</span>
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