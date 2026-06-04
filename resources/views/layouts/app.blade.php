<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carvix — @yield('title', 'Layanan Otomotif Presisi')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <span class="logo-icon">◈</span>
        <span class="logo-text">CARVIX</span>
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('home') }}"     class="{{ request()->routeIs('home') ? 'active' : '' }}">BERANDA</a></li>
        <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">LAYANAN</a></li>
        <li><a href="{{ route('track') }}"    class="{{ request()->routeIs('track*') ? 'active' : '' }}">LACAK</a></li>
        @auth
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">DASBOR</a></li>
        <li><a href="{{ route('history') }}"   class="{{ request()->routeIs('history') ? 'active' : '' }}">RIWAYAT</a></li>
        @endauth
    </ul>

    <div class="navbar-right">
        <a href="{{ route('booking') }}" class="btn-nav">PESAN LAYANAN</a>

        @auth
        <!-- USER DROPDOWN -->
        <div class="user-menu" id="userMenu">
            <button class="user-menu-btn" onclick="toggleUserMenu()" aria-expanded="false">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
                <svg class="chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-dropdown-header">
                    <p class="dropdown-name">{{ Auth::user()->name }}</p>
                    <p class="dropdown-email">{{ Auth::user()->email }}</p>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('dashboard') }}" class="dropdown-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="8" y="1" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="1" y="8" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="8" y="8" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/></svg>
                    Dasbor
                </a>
                <a href="{{ route('history') }}" class="dropdown-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.3"/><path d="M7 4V7L9 9" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                    Riwayat Layanan
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-logout">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 2H2a1 1 0 00-1 1v8a1 1 0 001 1h3M9 10l3-3-3-3M5 7h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        @else
        <!-- LOGIN BUTTON -->
        <a href="{{ route('login') }}" class="btn-nav-login">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="vertical-align:-2px;margin-right:5px"><circle cx="7" cy="4.5" r="2.5" stroke="currentColor" stroke-width="1.3"/><path d="M1.5 12c0-2.485 2.462-4.5 5.5-4.5s5.5 2.015 5.5 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            MASUK
        </a>
        @endauth
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
    <div class="alert-success">
        <span>✓</span> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert-error-flash">
        <span>✕</span> {{ session('error') }}
    </div>
@endif

<!-- MAIN CONTENT -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="logo-icon">◈</span>
            <span class="logo-text">CARVIX</span>
            <p>Sistem Manajemen Service Kendaraan Digital</p>
        </div>
        <div class="footer-links">
            <h4>Navigasi</h4>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('booking') }}">Pesan Layanan</a>
            <a href="{{ route('track') }}">Lacak Kendaraan</a>
            @auth
            <a href="{{ route('history') }}">Riwayat Layanan</a>
            @endauth
        </div>
        <div class="footer-contact">
            <h4>Kontak</h4>
            <p>Jl. Industri Raya No. 88, Jakarta Barat</p>
            <p>DKI Jakarta, 11450</p>
            <p>+62 21 922-0000</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} Carvix Precision Engineering. Semua hak dilindungi.</p>
    </div>
</footer>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    const dropdown = document.getElementById('userDropdown');
    const btn = menu.querySelector('.user-menu-btn');
    const isOpen = menu.classList.toggle('open');
    btn.setAttribute('aria-expanded', isOpen);
}

// Tutup jika klik di luar
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (menu && !menu.contains(e.target)) {
        menu.classList.remove('open');
        menu.querySelector('.user-menu-btn')?.setAttribute('aria-expanded', 'false');
    }
});
</script>

@stack('scripts')
<script src="{{ asset('js/animations.js') }}"></script>
</body>
</html>