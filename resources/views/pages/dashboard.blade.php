@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="p-6 space-y-6">

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-border shadow p-5 flex items-center gap-4">
                <span class="w-12 h-12 bg-primary-light text-primary rounded-xl flex items-center justify-center text-xl"><i
                        class="fa-solid fa-car-side"></i></span>
                <div>
                    <div class="text-2xl font-extrabold">{{ $totalMobil }}</div>
                    <div class="text-xs text-text-light font-medium">Total Mobil</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border shadow p-5 flex items-center gap-4">
                <span class="w-12 h-12 bg-emerald-50 text-success rounded-xl flex items-center justify-center text-xl"><i
                        class="fa-solid fa-circle-check"></i></span>
                <div>
                    <div class="text-2xl font-extrabold">{{ $mobilTersedia }}</div>
                    <div class="text-xs text-text-light font-medium">Mobil Tersedia</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border shadow p-5 flex items-center gap-4">
                <span class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-xl"><i
                        class="fa-solid fa-hourglass-half"></i></span>
                <div>
                    <div class="text-2xl font-extrabold">{{ $transaksiPending }}</div>
                    <div class="text-xs text-text-light font-medium">Booking Pending</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border shadow p-5 flex items-center gap-4">
                <span class="w-12 h-12 bg-amber-50 text-warning rounded-xl flex items-center justify-center text-xl"><i
                        class="fa-solid fa-key"></i></span>
                <div>
                    <div class="text-2xl font-extrabold">{{ $transaksiAktif }}</div>
                    <div class="text-xs text-text-light font-medium">Sedang Disewa</div>
                </div>
            </div>
        </div>

        <!-- Transaksi terbaru -->
        <div class="bg-white rounded-2xl border border-border shadow overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                <h2 class="font-bold">Transaksi Terbaru</h2>
                <a href="{{ route('admin.transaksi.index') }}"
                    class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm min-w-[700px]">
                    <thead>
                        <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">#</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Mobil</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Atas Nama</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Tanggal</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Total</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-text">
                        @forelse ($transaksies as $trx)
                            <tr class="hover:bg-[#f8fafd] transition">
                                <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $trx->id }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->car?->nama ?? '-' }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->atas_nama }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3.5 border-b border-border font-semibold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ ucfirst($trx->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-text-light">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
