@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div style="padding:2rem;max-width:1200px;margin:0 auto">

    <div style="margin-bottom:2rem">
        <p style="opacity:.5;font-size:.8rem;letter-spacing:.1em;color:#555">PANEL ADMIN</p>
        <h1 style="font-size:1.8rem;font-weight:700;color:#111">Selamat datang, {{ Auth::user()->name }}</h1>
    </div>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:2.5rem">
        @foreach([
            ['label'=>'Menunggu',    'key'=>'pending',     'color'=>'var(--yellow-dark)', 'bg'=>'#fef3c7'],
            ['label'=>'Dikonfirmasi','key'=>'confirmed',   'color'=>'#2563eb', 'bg'=>'#dbeafe'],
            ['label'=>'Dalam Proses','key'=>'in_progress', 'color'=>'#7c3aed', 'bg'=>'#ede9fe'],
            ['label'=>'Selesai',     'key'=>'completed',   'color'=>'#059669', 'bg'=>'#d1fae5'],
        ] as $s)
        <div style="background:{{ $s['bg'] }};border:1px solid {{ $s['color'] }}33;border-radius:14px;padding:1.5rem">
            <p style="font-size:.75rem;letter-spacing:.1em;color:{{ $s['color'] }};font-weight:600;margin-bottom:.5rem">{{ $s['label'] }}</p>
            <p style="font-size:2.2rem;font-weight:700;color:{{ $s['color'] }}">{{ $stats[$s['key']] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Recent Bookings --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h2 style="font-size:1.1rem;font-weight:700;color:#111">Booking Terbaru</h2>
        <a href="{{ route('admin.bookings.index') }}" style="font-size:.85rem;color:var(--yellow-dark);font-weight:600;text-decoration:none">Lihat semua →</a>
    </div>

    <div style="display:grid;gap:.75rem">
        @forelse($recentBookings as $b)
        @php
            $colors = ['pending'=>'var(--yellow-dark)','confirmed'=>'#2563eb','in_progress'=>'#7c3aed','completed'=>'#059669','cancelled'=>'#dc2626'];
            $bgs    = ['pending'=>'#fef3c7','confirmed'=>'#dbeafe','in_progress'=>'#ede9fe','completed'=>'#d1fae5','cancelled'=>'#fee2e2'];
            $labels = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','in_progress'=>'Dalam Proses','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
        @endphp
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.25rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;box-shadow:0 1px 4px rgba(0,0,0,.06)">
            <div>
                <p style="font-weight:700;color:#111;margin-bottom:.25rem">{{ $b->booking_code }}</p>
                <p style="font-size:.85rem;color:#666">{{ $b->vehicle->owner_name ?? '-' }} — {{ $b->service_type }}</p>
            </div>
            <div style="display:flex;align-items:center;gap:1rem">
                <span style="font-size:.75rem;padding:4px 12px;border-radius:999px;background:{{ $bgs[$b->status] ?? '#f3f4f6' }};color:{{ $colors[$b->status] ?? '#666' }};font-weight:600">
                    {{ $labels[$b->status] ?? $b->status }}
                </span>
                <a href="{{ route('admin.bookings.show', $b->id) }}" style="font-size:.85rem;color:var(--yellow-dark);font-weight:600;text-decoration:none">Detail →</a>
            </div>
        </div>
        @empty
        <div style="background:#f9fafb;border:1px dashed #d1d5db;border-radius:12px;padding:3rem;text-align:center;color:#9ca3af">
            Belum ada booking.
        </div>
        @endforelse
    </div>
    
</div>

@endsection