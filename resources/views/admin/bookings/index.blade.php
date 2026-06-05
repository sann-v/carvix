@extends('layouts.admin')
@section('title', 'Kelola Booking')

@section('content')
<div style="padding:2rem;max-width:1200px;margin:0 auto">

    <div style="margin-bottom:2rem">
        <a href="{{ route('admin.dashboard') }}" style="font-size:.85rem;color:var(--yellow-dark);text-decoration:none;font-weight:600">← Dashboard</a>
        <h1 style="font-size:1.8rem;font-weight:700;color:#111;margin-top:.5rem">Kelola Booking</h1>
    </div>

    @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:1rem;border-radius:8px;margin-bottom:1.5rem;font-weight:500">
        {{ session('success') }}
    </div>
    @endif

    {{-- Filter Tab --}}
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:2rem">
        @foreach([
            'all'         => 'Semua ('.$counts['all'].')',
            'pending'     => 'Menunggu ('.$counts['pending'].')',
            'confirmed'   => 'Dikonfirmasi ('.$counts['confirmed'].')',
            'in_progress' => 'Dalam Proses ('.$counts['in_progress'].')',
            'completed'   => 'Selesai ('.$counts['completed'].')',
            'cancelled'   => 'Dibatalkan ('.$counts['cancelled'].')',
            'paid'        => 'Lunas ('.$counts['paid'].')',
            'unpaid'      => 'Belum Lunas ('.$counts['unpaid'].')',
        ] as $key => $label)
        <a href="?status={{ $key }}"
           style="font-size:.8rem;padding:6px 16px;border-radius:999px;border:1px solid {{ $status===$key ? 'var(--yellow-dark)' : '#d1d5db' }};background:{{ $status===$key ? 'var(--yellow-dark)' : '#fff' }};color:{{ $status===$key ? '#000' : '#555' }};text-decoration:none;font-weight:{{ $status===$key ? '700' : '400' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Kartu Booking --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.25rem">
        @forelse($bookings as $b)
        @php
            $colors = ['pending'=>'var(--yellow-dark)','confirmed'=>'#2563eb','in_progress'=>'#7c3aed','completed'=>'#059669','cancelled'=>'#dc2626'];
            $bgs    = ['pending'=>'#fef3c7','confirmed'=>'#dbeafe','in_progress'=>'#ede9fe','completed'=>'#d1fae5','cancelled'=>'#fee2e2'];
            $labels = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','in_progress'=>'Dalam Proses','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
        @endphp
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:1.5rem;display:flex;flex-direction:column;gap:1rem;box-shadow:0 2px 8px rgba(0,0,0,.06)">

            {{-- Header --}}
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <div>
                    <p style="font-size:.7rem;letter-spacing:.1em;color:#9ca3af;margin-bottom:.25rem">{{ $b->booking_code }}</p>
                    <p style="font-weight:700;color:#111">{{ $b->vehicle->owner_name ?? 'Tanpa Nama' }}</p>
                    <p style="font-size:.85rem;color:#666;margin-top:.1rem">{{ $b->service_type }}</p>
                </div>
                <span style="font-size:.72rem;padding:4px 10px;border-radius:999px;background:{{ $bgs[$b->status] ?? '#f3f4f6' }};color:{{ $colors[$b->status] ?? '#666' }};font-weight:700;white-space:nowrap">
                    {{ $labels[$b->status] ?? $b->status }}
                </span>
            </div>

            {{-- Info --}}
            <div style="font-size:.82rem;color:#555;display:grid;gap:.3rem">
                <span> {{ $b->vehicle->brand ?? '' }} {{ $b->vehicle->model ?? '' }} — {{ $b->vehicle->license_plate ?? '-' }}</span>
                <span> {{ \Carbon\Carbon::parse($b->service_date)->format('d M Y') }}</span>
                @if($b->handled_by)
                <span> Ditangani: <strong style="color:#111">{{ $b->handled_by }}</strong></span>
                @endif
                @if($b->estimated_finish)
                <span> Estimasi: <strong style="color:#111">{{ \Carbon\Carbon::parse($b->estimated_finish)->format('d M Y, H:i') }}</strong></span>
                @endif
                @if($b->service_cost)
                <span> Biaya: <strong style="color:#111">Rp {{ number_format($b->service_cost, 0, ',', '.') }}</strong></span>
                @endif
            </div>

            {{-- Progress Bar --}}
            <div style="background:#f3f4f6;border-radius:999px;height:5px">
                <div style="background:{{ $colors[$b->status] ?? '#ccc' }};height:5px;border-radius:999px;width:{{ $b->progress ?? 0 }}%;transition:width .3s"></div>
            </div>

            <a href="{{ route('admin.bookings.show', $b->id) }}"
               style="text-align:center;padding:.65rem;background:var(--yellow-dark);color:#000;border-radius:8px;font-size:.85rem;font-weight:700;text-decoration:none">
                Kelola →
            </a>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;background:#f9fafb;border:1px dashed #d1d5db;border-radius:12px">
            Tidak ada booking dengan status ini.
        </div>
        @endforelse
    </div>

    <div style="margin-top:2rem">
        @if(method_exists($bookings, 'links'))
            {{ $bookings->links() }}
        @endif
    </div>
</div>
@endsection
