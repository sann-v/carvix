@extends('layouts.admin')
@section('title', 'Detail Booking')

@section('content')
<div style="padding:2rem;max-width:860px;margin:0 auto">

    <a href="{{ route('admin.bookings.index') }}"
       style="font-size:.85rem;color:#f59e0b;text-decoration:none;font-weight:600">← Kembali ke Daftar</a>

    <div style="margin:1rem 0 2rem">
        <p style="font-size:.7rem;letter-spacing:.12em;color:#9ca3af;margin-bottom:.25rem">{{ $booking->booking_code }}</p>
        <h1 style="font-size:1.6rem;font-weight:700;color:#111">{{ $booking->vehicle->owner_name ?? 'Tanpa Nama' }}</h1>
        <p style="color:#555;margin-top:.25rem">{{ $booking->service_type }}</p>
    </div>

    @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:1rem;border-radius:8px;margin-bottom:1.5rem;font-weight:500">
        {{ session('success') }}
    </div>
    @endif

    {{-- INFO KENDARAAN --}}
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.5rem;margin-bottom:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,.06)">
        <p style="font-size:.72rem;letter-spacing:.12em;color:#f59e0b;font-weight:700;margin-bottom:1.25rem">INFORMASI KENDARAAN</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;font-size:.9rem">
            <div>
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.2rem">Pemilik</p>
                <p style="color:#111;font-weight:600">{{ $booking->vehicle->owner_name ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.2rem">Kendaraan</p>
                <p style="color:#111;font-weight:600">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} ({{ $booking->vehicle->year }})</p>
            </div>
            <div>
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.2rem">Plat Nomor</p>
                <p style="color:#111;font-weight:600">{{ $booking->vehicle->license_plate ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.2rem">Tanggal Servis</p>
                <p style="color:#111;font-weight:600">{{ \Carbon\Carbon::parse($booking->service_date)->format('d M Y') }}</p>
            </div>
            <div style="grid-column:1/-1">
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.2rem">Keluhan</p>
                <p style="color:#111;font-weight:600">{{ $booking->complaint ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- STATUS FAKTUR SEKARANG (jika ada) --}}
    @if($booking->invoice)
    <div style="background:#fff;border:2px solid {{ $booking->invoice->isPaid() ? '#6ee7b7' : '#fde68a' }};border-radius:12px;padding:1.5rem;margin-bottom:1.5rem">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
            <div>
                <p style="font-size:.72rem;letter-spacing:.12em;color:#f59e0b;font-weight:700;margin-bottom:.4rem">FAKTUR AKTIF</p>
                <p style="font-weight:700;color:#111;font-size:1rem">{{ $booking->invoice->invoice_number }}</p>
                <p style="font-size:.85rem;color:#555;margin-top:.2rem">
                    Total: <strong>Rp {{ number_format($booking->invoice->total, 0, ',', '.') }}</strong>
                    &nbsp;·&nbsp; Jatuh Tempo: {{ $booking->invoice->due_date->format('d M Y') }}
                    @if($booking->invoice->paid_at)
                    &nbsp;·&nbsp; Dibayar: <strong>{{ $booking->invoice->paid_at->format('d M Y, H:i') }}</strong>
                    @endif
                </p>
            </div>
            <div style="display:flex;align-items:center;gap:1rem">
                <span style="font-size:.8rem;padding:6px 14px;border-radius:999px;font-weight:700;
                    background:{{ $booking->invoice->isPaid() ? '#d1fae5' : '#fef3c7' }};
                    color:{{ $booking->invoice->isPaid() ? '#065f46' : '#92400e' }}">
                    {{ $booking->invoice->isPaid() ?  'LUNAS' : 'BELUM LUNAS' }}
                </span>
                {{-- TOMBOL CEPAT UBAH STATUS BAYAR --}}
                @if(!$booking->invoice->isPaid())
                <form action="{{ route('admin.invoice.payment', $booking->invoice->id) }}" method="POST" style="display:inline">
                    @csrf
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit"
                            onclick="return confirm('Tandai faktur ini sebagai LUNAS?')"
                            style="background:#059669;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:.8rem;font-weight:700;cursor:pointer">
                        ✓ Tandai Lunas
                    </button>
                </form>
                @else
                <form action="{{ route('admin.invoice.payment', $booking->invoice->id) }}" method="POST" style="display:inline">
                    @csrf
                    <input type="hidden" name="payment_status" value="unpaid">
                    <button type="submit"
                            onclick="return confirm('Batalkan status lunas faktur ini?')"
                            style="background:#dc2626;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:.8rem;font-weight:700;cursor:pointer">
                        ✕ Batal Lunas
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($booking->invoice)
    @php
        $phone = preg_replace('/[^0-9]/', '', preg_replace('/^0/', '62', trim($booking->vehicle->phone)));
        $message = urlencode(
            'Halo ' . $booking->vehicle->owner_name . ', invoice servis kendaraan Anda sudah tersedia.' .
            ' No Invoice: ' . $booking->invoice->invoice_number .
            ' Dengan kendaraan: ' . $booking->vehicle->brand . ' ' . $booking->vehicle->model .
            ' Total: Rp ' . number_format($booking->invoice->total, 0, ',', '.') .
            ' Silakan lakukan pembayaran atau hubungi admin untuk info lebih lanjut.'
        );
        $waUrl = 'https://wa.me/' . $phone . '?text=' . $message;
    @endphp

    <a href="{{ $waUrl }}"
       target="_blank"
       style="display:inline-block;background:#25D366;color:#fff;padding:.8rem 1rem;border-radius:8px;text-decoration:none;font-weight:700">
        Kirim Invoice ke WhatsApp
    </a>
    @endif

    {{-- FORM UPDATE BOOKING + FAKTUR --}}
    <div style="margin-top:1.5rem; background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,.06)">
        <p style="font-size:.72rem;letter-spacing:.12em;color:#f59e0b;font-weight:700;margin-bottom:1.5rem">UPDATE STATUS & FAKTUR</p>

                @if ($errors->any())
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:1rem;border-radius:10px;margin-bottom:1.5rem">
            <p style="font-weight:700;margin-bottom:.5rem">
                Ada data yang belum valid
            </p>

            <ul style="margin:0;padding-left:1.2rem;font-size:.9rem">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" style="display:grid;gap:1.25rem">
            @csrf

            {{-- Status Booking --}}
            <div>
                <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">STATUS BOOKING</label>
                <select name="status" style="width:100%;background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.75rem 1rem;border-radius:8px;font-size:.9rem;font-weight:500">
                    @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','in_progress'=>'Dalam Proses','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val => $lbl)
                    <option value="{{ $val }}" {{ $booking->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Teknisi --}}
            <div>
                <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">DITANGANI OLEH</label>
                <input type="text" name="handled_by" required value="{{ old('handled_by', $booking->handled_by) }}"
                       placeholder="Nama teknisi / karyawan"
                       style="width:100%;background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.75rem 1rem;border-radius:8px;font-size:.9rem;box-sizing:border-box;font-weight:500">
            </div>

            {{-- Estimasi Selesai --}}
            <div>
                <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">ESTIMASI SELESAI</label>
                <input type="datetime-local" name="estimated_finish"
                       value="{{ old('estimated_finish', $booking->estimated_finish ? \Carbon\Carbon::parse($booking->estimated_finish)->format('Y-m-d\TH:i') : '') }}"
                       style="width:100%;background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.75rem 1rem;border-radius:8px;font-size:.9rem;box-sizing:border-box;font-weight:500">
            </div>

            {{-- Catatan --}}
            <div>
                <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">CATATAN SERVIS</label>
                <textarea name="admin_notes" required rows="3"
                          placeholder="Catatan untuk pelanggan..."
                          style="width:100%;background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.75rem 1rem;border-radius:8px;font-size:.9rem;resize:vertical;box-sizing:border-box;font-weight:500">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
            </div>

            <hr style="border:none;border-top:1px solid #e5e7eb">

            {{-- SEKSI FAKTUR --}}
            <div>
                <p style="font-size:.72rem;letter-spacing:.12em;color:#f59e0b;font-weight:700;margin-bottom:1rem">
                    {{ $booking->invoice ? 'UPDATE FAKTUR' : 'BUAT FAKTUR BARU' }}
                </p>

                {{-- Item-item faktur --}}
                <div id="invoice-items" style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1rem">
                    @if($booking->invoice && $booking->invoice->items)
                        @foreach($booking->invoice->items as $i => $item)
                        <div class="inv-item-row-admin" style="display:grid;grid-template-columns:1fr 80px 140px 32px;gap:.5rem;align-items:center">
                            <input type="text" name="invoice_items[{{ $i }}][description]"
                                   value="{{ $item['description'] }}" placeholder="Deskripsi layanan/suku cadang"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box">
                            <input type="number" name="invoice_items[{{ $i }}][qty]"
                                   value="{{ $item['qty'] }}" placeholder="Qty" min="1"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box;text-align:center">
                            <input type="number" name="invoice_items[{{ $i }}][unit_price]"
                                   value="{{ $item['unit_price'] }}" placeholder="Harga satuan (Rp)" min="0"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box">
                            <button type="button" onclick="this.closest('.inv-item-row-admin').remove(); recalc()"
                                    style="background:#fee2e2;color:#dc2626;border:none;width:32px;height:32px;border-radius:6px;cursor:pointer;font-size:1rem;font-weight:700">✕</button>
                        </div>
                        @endforeach
                    @else
                        <div class="inv-item-row-admin" style="display:grid;grid-template-columns:1fr 80px 140px 32px;gap:.5rem;align-items:center">
                            <input type="text" name="invoice_items[0][description]"
                                   value="{{ $booking->service_type }}" placeholder="Deskripsi"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box">
                            <input type="number" name="invoice_items[0][qty]" value="1" placeholder="Qty" min="1"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box;text-align:center">
                            <input type="number" name="invoice_items[0][unit_price]"
                                   value="{{ $booking->service_cost ?? '' }}" placeholder="Harga (Rp)" min="0"
                                   style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box">
                            <button type="button" onclick="this.closest('.inv-item-row-admin').remove(); recalc()"
                                    style="background:#fee2e2;color:#dc2626;border:none;width:32px;height:32px;border-radius:6px;cursor:pointer;font-size:1rem;font-weight:700">✕</button>
                        </div>
                    @endif
                </div>

                {{-- Tombol tambah item --}}
                <button type="button" onclick="addItem()"
                        style="background:#f3f4f6;border:1px dashed #d1d5db;color:#374151;padding:.55rem 1rem;border-radius:8px;font-size:.82rem;font-weight:600;cursor:pointer;width:100%;margin-bottom:1rem">
                    + Tambah Item
                </button>

                {{-- Preview total otomatis --}}
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:1rem;font-size:.85rem">
                    <div style="display:flex;justify-content:space-between;margin-bottom:.3rem">
                        <span style="color:#555">Subtotal</span>
                        <span id="preview-subtotal" style="font-weight:600">Rp 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:.3rem">
                        <span style="color:#555">Pajak (11%)</span>
                        <span id="preview-tax" style="font-weight:600">Rp 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding-top:.5rem;border-top:1px solid #e5e7eb">
                        <span style="font-weight:700;color:#111">TOTAL</span>
                        <span id="preview-total" style="font-weight:800;color:#f59e0b;font-size:1rem">Rp 0</span>
                    </div>
                </div>

                <div class="form-group" style="margin-top:1rem">
                    <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">TANGGAL JATUH TEMPO</label>
                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}"
                        class="form-control">
                </div>

                {{-- Status Pembayaran --}}
                <div style="margin-top:1rem">
                    <label style="font-size:.78rem;letter-spacing:.08em;color:#374151;font-weight:600;display:block;margin-bottom:.5rem">STATUS PEMBAYARAN FAKTUR</label>
                    <select name="payment_status"
                            style="width:100%;background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.75rem 1rem;border-radius:8px;font-size:.9rem;font-weight:500">
                        <option value="unpaid"    {{ ($booking->invoice?->payment_status ?? 'unpaid') === 'unpaid'    ? 'selected' : '' }}> Belum Lunas</option>
                        <option value="paid"      {{ ($booking->invoice?->payment_status ?? '') === 'paid'            ? 'selected' : '' }}> Lunas</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                    style="background:#f59e0b;color:#000;border:none;padding:.9rem;border-radius:8px;font-weight:700;font-size:.95rem;letter-spacing:.05em;cursor:pointer;margin-top:.5rem">
                SIMPAN SEMUA PERUBAHAN →
            </button>
        </form>
    </div>

</div>

<script>
let itemIndex = {{ $booking->invoice && $booking->invoice->items ? count($booking->invoice->items) : 1 }};

function addItem() {
    const container = document.getElementById('invoice-items');
    const div = document.createElement('div');
    div.className = 'inv-item-row-admin';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 80px 140px 32px;gap:.5rem;align-items:center';
    div.innerHTML = `
        <input type="text" name="invoice_items[${itemIndex}][description]" placeholder="Deskripsi layanan/suku cadang"
               style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box" oninput="recalc()">
        <input type="number" name="invoice_items[${itemIndex}][qty]" value="1" placeholder="Qty" min="1"
               style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box;text-align:center" oninput="recalc()">
        <input type="number" name="invoice_items[${itemIndex}][unit_price]" placeholder="Harga (Rp)" min="0"
               style="background:#f9fafb;border:1px solid #d1d5db;color:#111;padding:.6rem .8rem;border-radius:8px;font-size:.85rem;box-sizing:border-box" oninput="recalc()">
        <button type="button" onclick="this.closest('.inv-item-row-admin').remove(); recalc()"
                style="background:#fee2e2;color:#dc2626;border:none;width:32px;height:32px;border-radius:6px;cursor:pointer;font-size:1rem;font-weight:700">✕</button>
    `;
    container.appendChild(div);
    itemIndex++;
    recalc();
}

function recalc() {
    let subtotal = 0;
    document.querySelectorAll('.inv-item-row-admin').forEach(row => {
        const qty   = parseFloat(row.querySelector('input[name*="[qty]"]')?.value) || 0;
        const price = parseFloat(row.querySelector('input[name*="[unit_price]"]')?.value) || 0;
        subtotal += qty * price;
    });
    const tax   = Math.round(subtotal * 0.11);
    const total = subtotal + tax;
    const fmt   = v => 'Rp ' + Math.round(v).toLocaleString('id-ID');
    document.getElementById('preview-subtotal').textContent = fmt(subtotal);
    document.getElementById('preview-tax').textContent      = fmt(tax);
    document.getElementById('preview-total').textContent    = fmt(total);
}

// Hitung saat halaman dimuat
document.querySelectorAll('.inv-item-row-admin input').forEach(el => el.addEventListener('input', recalc));
recalc();
</script>
@endsection
