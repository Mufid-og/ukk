@extends('layouts.landing')

@section('title', 'Riwayat Booking Saya')

@section('content')
    <div class="max-w-4xl mx-auto p-6 w-full">

        <h1 class="text-2xl font-bold mb-1">Riwayat Booking Saya</h1>
        <p class="text-text-light text-sm mb-6">Semua transaksi dengan nomor telepon {{ auth()->user()->telepone }}</p>

        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4 pb-12">
            @forelse ($transaksies as $trx)
                <div class="bg-white rounded-2xl border border-border shadow p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                    <!-- Ikon mobil -->
                    <div class="w-14 h-14 bg-primary-light text-primary rounded-xl flex items-center justify-center text-2xl shrink-0">
                        <i class="fa-solid fa-car-side"></i>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-0.5">
                            <h3 class="font-bold">{{ $trx->car->nama }}</h3>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wide px-2.5 py-0.5 rounded-full
                                {{ $trx->status === 'pending' ? 'bg-sky-100 text-sky-800 border border-sky-200' : '' }}
                                {{ $trx->status === 'disewakan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                                {{ $trx->status === 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}">
                                @if ($trx->status === 'pending') Menunggu Verifikasi
                                @elseif ($trx->status === 'disewakan') Disewakan
                                @else Selesai @endif
                            </span>
                        </div>
                        <p class="text-xs text-text-light font-medium mb-1">{{ $trx->car->brand->brand }} •
                            {{ $trx->car->kelas->kelas }}</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-0.5 text-xs text-text-light font-medium">
                            <span><i class="fa-solid fa-calendar-days mr-1"></i>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</span>
                            <span><i class="fa-solid fa-hourglass-half mr-1"></i>{{ $trx->durasi_sewa }} hari</span>
                            <span><i class="fa-solid fa-user mr-1"></i>{{ $trx->atas_nama }}</span>
                        </div>
                    </div>

                    <div class="text-left sm:text-right shrink-0">
                        <div class="text-lg font-extrabold text-accent">Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                        <div class="text-[11px] text-text-light">Full Payment</div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-border p-12 text-center">
                    <div class="text-5xl opacity-70 mb-4"><i class="fa-solid fa-clipboard-list"></i></div>
                    <h3 class="font-bold mb-1">Belum ada booking</h3>
                    <p class="text-text-light text-sm mb-5">Anda belum melakukan booking sama sekali.</p>
                    <a href="{{ route('landing') }}"
                        class="inline-block bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-full text-sm font-semibold transition">
                        <i class="fa-solid fa-key mr-1.5"></i> Booking Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
