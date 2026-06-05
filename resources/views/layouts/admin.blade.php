<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skensa Auto Service Admin — @yield('title', 'Panel Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    @stack('styles')
</head>
<body>

@auth
<nav class="navbar" style="border-bottom:1px solid var(--yellow-dark)33">

    <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
        <span class="logo-icon" style="color:var(--yellow-dark)">◈</span>
        <span class="logo-text">Skensa Auto Service</span>
        <span style="font-size:.65rem;letter-spacing:.15em;background:var(--yellow-dark)22;color:var(--yellow-dark);padding:3px 10px;border-radius:999px;margin-left:.5rem">ADMIN</span>
    </a>

    <ul class="nav-links">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">DASHBOARD</a>
        </li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">KELOLA BOOKING</a>
        </li>
    </ul>

    <div class="navbar-right">

        {{-- Tombol nama + chevron --}}
        <div style="position:relative" id="adminMenu">
            <button onclick="toggleAdminMenu()"
                    style="display:flex;align-items:center;gap:.6rem;background:transparent;border:1px solid #333;border-radius:999px;padding:.4rem .9rem .4rem .5rem;cursor:pointer;color:#ffffff">
                <div style="width:30px;height:30px;border-radius:50%;background:var(--yellow-dark)22;color:var(--yellow-dark);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span style="font-size:.85rem;font-weight:500">{{ Auth::user()->name }}</span>
                <svg id="adminChevron" width="12" height="12" viewBox="0 0 12 12" fill="none" style="transition:transform .2s">
                    <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div id="adminDropdown"
                 style="display:none;position:absolute;right:0;top:calc(100% + 8px);background:#111;border:1px solid #222;border-radius:12px;min-width:200px;padding:.5rem;z-index:999;box-shadow:0 8px 32px rgba(0,0,0,.4)">

                <div style="padding:.75rem 1rem;border-bottom:1px solid #222;margin-bottom:.25rem">
                    <p style="font-weight:600;font-size:.9rem; color: #ffffff;">{{ Auth::user()->name }}</p>
                    <p style="font-size:.72rem;color:var(--yellow-dark);letter-spacing:.08em;margin-top:.15rem">ADMIN</p>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   style="display:flex;align-items:center;gap:.6rem;padding:.6rem 1rem;border-radius:8px;font-size:.85rem;text-decoration:none;color:#ffffff;transition:background .15s"
                   onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='transparent'">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="8" y="1" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="1" y="8" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="8" y="8" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                   style="display:flex;align-items:center;gap:.6rem;padding:.6rem 1rem;border-radius:8px;font-size:.85rem;text-decoration:none;color:#ffffff;transition:background .15s"
                   onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='transparent'">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 4h10M2 7h10M2 10h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                    Kelola Booking
                </a>

                <div style="border-top:1px solid #222;margin:.25rem 0"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            style="display:flex;align-items:center;gap:.6rem;padding:.6rem 1rem;border-radius:8px;font-size:.85rem;color:#ef4444;background:transparent;border:none;cursor:pointer;width:100%;text-align:left;transition:background .15s"
                            onmouseover="this.style.background='#ef444411'" onmouseout="this.style.background='transparent'">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 2H2a1 1 0 00-1 1v8a1 1 0 001 1h3M9 10l3-3-3-3M5 7h7" stroke="#ef4444" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Keluar
                    </button>
                </form>

            </div>
        </div>

    </div>
</nav>
@endauth

@if(session('success'))
<div class="flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="flash-error">{{ session('error') }}</div>
@endif

<main>
    @yield('content')
</main>

@stack('scripts')
<script>
function toggleAdminMenu() {
    const dropdown = document.getElementById('adminDropdown');
    const chevron  = document.getElementById('adminChevron');
    const isOpen   = dropdown.style.display === 'block';
    dropdown.style.display = isOpen ? 'none' : 'block';
    chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('adminMenu');
    if (menu && !menu.contains(e.target)) {
        document.getElementById('adminDropdown').style.display = 'none';
        document.getElementById('adminChevron').style.transform = 'rotate(0deg)';
    }
});
</script>
</body>
</html>