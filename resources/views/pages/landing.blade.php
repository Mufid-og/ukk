@extends('layouts.landing')

@section('title', 'Katalog Mobil')

@section('content')
    <!-- Hero -->
    <section class="bg-gradient-to-br from-[#0a1628] via-[#1a3a5c] to-[#1a5276] text-white px-6 py-14 sm:py-20 text-center">
        <h1 class="text-3xl sm:text-5xl font-extrabold mb-4">Sewa Mobil <span class="text-amber-400">Impian</span> Anda</h1>
        <p class="text-white/85 max-w-2xl mx-auto mb-8">Pilih dari berbagai kelas, brand, dan model mobil terbaik. Proses
            cepat, harga transparan, dan armada selalu terawat.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <span class="bg-white/10 border border-white/20 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-400"></i> Armada Terawat
            </span>
            <span class="bg-white/10 border border-white/20 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                <i class="fa-solid fa-tags text-amber-400"></i> Harga Kompetitif
            </span>
            <span class="bg-white/10 border border-white/20 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                <i class="fa-solid fa-clock text-sky-300"></i> Booking 24/7
            </span>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-6 w-full">
        @if (session('success'))
            <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Filter -->
        <form method="GET" action="{{ route('landing') }}"
            class="bg-white rounded-2xl border border-border shadow-lg p-5 sm:p-7 -mt-8 relative z-10">
            <h3 class="text-xs font-bold uppercase tracking-widest text-text-light mb-3 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-primary"></i> Cari Mobil
            </h3>
            <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="flex-1 min-w-[160px]">
                    <label for="kelas" class="block text-[11px] font-bold uppercase tracking-wide text-text-light mb-1.5">Kelas
                        Mobil</label>
                    <select id="kelas" name="kelas"
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}" {{ request('kelas') == $kls->id ? 'selected' : '' }}>{{ $kls->kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[160px]">
                    <label for="brand"
                        class="block text-[11px] font-bold uppercase tracking-wide text-text-light mb-1.5">Brand</label>
                    <select id="brand" name="brand"
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        <option value="">Semua Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->brand }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('landing') }}"
                    class="inline-flex justify-center items-center gap-2 px-5 py-3 bg-white border-2 border-border hover:border-slate-300 text-text-light rounded-xl text-sm font-semibold transition">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>

        <!-- Info hasil -->
        <div class="flex flex-wrap justify-between items-center gap-3 mt-8 mb-5">
            <span class="font-semibold text-text-light text-sm">Menampilkan <strong class="text-base text-text">{{ $cars->count() }}</strong>
                mobil</span>
            <div class="flex gap-2 flex-wrap">
                @if (request('kelas'))
                    @php($klsTerpilih = $kelas->firstWhere('id', (int) request('kelas')))
                    <span class="bg-primary-light text-primary-dark px-3.5 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5">
                        Kelas: {{ $klsTerpilih?->kelas ?? '-' }}
                    </span>
                @endif
                @if (request('brand'))
                    @php($brandTerpilih = $brands->firstWhere('id', (int) request('brand')))
                    <span class="bg-primary-light text-primary-dark px-3.5 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5">
                        Brand: {{ $brandTerpilih?->brand ?? '-' }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Grid mobil -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
            @forelse ($cars as $car)
                <div
                    class="bg-white rounded-2xl border border-border shadow-lg overflow-hidden flex flex-col group hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                    <!-- Gambar + badge status -->
                    <div class="relative h-48 bg-gradient-to-br from-[#e8f0fe] to-[#d4e4fc] flex items-center justify-center overflow-hidden">
                        @if ($car->img && str_starts_with($car->img, 'mobil/'))
                            <img src="{{ asset('storage/' . $car->img) }}" alt="{{ $car->nama }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <span class="text-6xl text-slate-700 group-hover:scale-110 transition duration-500">
                                <i class="fa-solid fa-car-side"></i>
                            </span>
                        @endif
                        <span
                            class="absolute top-3.5 right-3.5 text-[11px] font-bold uppercase tracking-wide px-3 py-1 rounded-full
                            {{ $car->status === 'tersedia' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}
                            {{ $car->status === 'dibooking' ? 'bg-sky-100 text-sky-800 border border-sky-200 animate-pulse' : '' }}
                            {{ $car->status === 'disewakan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}">
                            @if ($car->status === 'tersedia')
                                Tersedia
                            @elseif ($car->status === 'dibooking')
                                Dibooking
                            @else
                                Disewakan
                            @endif
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="p-5 flex flex-col flex-1">
                        <span class="text-[11px] font-bold uppercase tracking-widest text-primary mb-1">{{ $car->kelas->kelas }}</span>
                        <h3 class="text-lg font-bold">{{ $car->nama }}</h3>
                        <p class="text-sm text-text-light font-medium mb-3">{{ $car->brand->brand }} • {{ $car->warna }} • Tahun
                            {{ $car->tahun }}</p>

                        <div class="flex flex-wrap gap-2 mb-3.5 text-xs text-text-light">
                            <span class="inline-flex items-center gap-1.5 bg-[#f9fafb] px-2.5 py-1.5 rounded-md font-medium">
                                <i class="fa-solid fa-gear"></i> {{ $car->transmisi }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-[#f9fafb] px-2.5 py-1.5 rounded-md font-medium">
                                <i class="fa-solid fa-users"></i> {{ $car->kursi }} Kursi
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-[#f9fafb] px-2.5 py-1.5 rounded-md font-medium">
                                <i class="fa-solid fa-calendar-days"></i> {{ $car->tahun }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-3.5 mt-auto border-t border-border">
                            <span class="text-xl font-extrabold text-accent">
                                Rp {{ number_format($car->harga, 0, ',', '.') }} <small
                                    class="text-xs font-medium text-text-light">/ hari</small>
                            </span>
                            @if ($car->status === 'tersedia')
                                <a href="{{ route('booking.create', $car->id) }}"
                                    class="bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 sm:px-5 py-2.5 rounded-full inline-flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-key"></i> Sewa Sekarang
                                </a>
                            @else
                                <span tabindex="-1" aria-disabled="true"
                                    class="bg-[#f1f3f5] text-gray-400 text-sm font-semibold px-4 sm:px-5 py-2.5 rounded-full inline-flex items-center gap-1.5 cursor-not-allowed select-none">
                                    <i class="fa-solid fa-lock"></i> Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-5xl opacity-70 mb-4"><i class="fa-solid fa-car-tunnel"></i></div>
                    <h3 class="text-lg font-bold mb-1">Tidak ada mobil ditemukan</h3>
                    <p class="text-text-light text-sm">Coba ubah filter atau reset pencarian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
