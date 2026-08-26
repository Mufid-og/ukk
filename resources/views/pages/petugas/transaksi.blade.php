@extends('layouts.mobile')

@section('title', 'Transaksi')

@section('content')
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

    <!-- Statistik ringkas -->
    <div class="flex gap-2.5 mb-4 overflow-x-auto">
        <div class="bg-white rounded-xl shadow-sm p-3.5 min-w-[100px] flex-1 text-center">
            <div class="text-2xl font-extrabold">{{ $statHariIni }}</div>
            <div class="text-[11px] text-text-light font-medium">Hari Ini</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-3.5 min-w-[100px] flex-1 text-center">
            <div class="text-2xl font-extrabold">{{ $statDisewakan }}</div>
            <div class="text-[11px] text-text-light font-medium">Disewa</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-3.5 min-w-[100px] flex-1 text-center">
            <div class="text-2xl font-extrabold text-sky-600">{{ $statPending }}</div>
            <div class="text-[11px] text-text-light font-medium">Pending</div>
        </div>
    </div>

    <!-- Perlu verifikasi (booking dari web) -->
    <h2 class="text-xs font-bold uppercase tracking-widest text-text-light mb-3 flex items-center gap-2">
        <i class="fa-solid fa-hourglass-half text-warning"></i> Menunggu Verifikasi
    </h2>

    <div class="space-y-3 mb-8">
        @forelse ($pending as $trx)
            <div class="bg-white rounded-xl border border-border shadow-sm p-4">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 bg-primary-light text-primary rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-car-side"></i>
                        </span>
                        <div>
                            <div class="font-bold text-sm">{{ $trx->car->nama }}</div>
                            <div class="text-[11px] text-text-light font-medium">{{ $trx->car->brand->brand }} •
                                {{ $trx->car->kelas->kelas }}</div>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold uppercase bg-sky-100 text-sky-800 border border-sky-200 px-2.5 py-1 rounded-full">Booking
                        Web</span>
                </div>

                <div class="grid grid-cols-2 gap-x-3 gap-y-1 text-xs text-text-light font-medium mb-3">
                    <span><i class="fa-solid fa-user mr-1 w-3"></i>{{ $trx->atas_nama }}</span>
                    <span><i class="fa-solid fa-phone mr-1 w-3"></i>{{ $trx->telepon }}</span>
                    <span><i class="fa-solid fa-calendar-days mr-1 w-3"></i>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</span>
                    <span><i class="fa-solid fa-hourglass mr-1 w-3"></i>{{ $trx->durasi_sewa }} hari</span>
                </div>

                <div class="flex items-center justify-between border-t border-border pt-3">
                    <span class="font-extrabold text-accent">Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                    <button type="button" data-modal="verifikasi-{{ $trx->id }}"
                        class="modal-open-btn bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-full text-xs font-semibold transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-camera"></i> Input Bukti & Verifikasi
                    </button>
                </div>

                <!-- Modal verifikasi (bottom sheet) -->
                <div id="verifikasi-{{ $trx->id }}"
                    class="modal-overlay hidden fixed inset-0 z-50 bg-black/50 flex items-end sm:items-center sm:justify-center">
                    <div class="bg-white w-full sm:max-w-md rounded-t-2xl sm:rounded-2xl p-5 max-h-[90vh] overflow-y-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold">Verifikasi Booking #{{ $trx->id }}</h3>
                            <button type="button" class="modal-close-btn text-text-light hover:text-danger text-xl w-8 h-8"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </div>
                        <p class="text-xs text-text-light mb-4">Unggah foto bukti penyewaan (foto penyewa bersama mobil),
                            lalu mobil otomatis berubah menjadi <strong>disewakan</strong>.</p>

                        <form method="POST" action="{{ route('petugas.transaksi.verifikasi', $trx->id) }}" enctype="multipart/form-data"
                            onsubmit="return confirm('Verifikasi booking ini? Mobil akan berubah menjadi disewakan.')">
                            @csrf
                            <label for="bukti-{{ $trx->id }}"
                                class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Foto Bukti Penyewaan</label>
                            <input type="file" id="bukti-{{ $trx->id }}" name="bukti_img" accept="image/*" required
                                class="w-full px-3 py-2.5 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary transition file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-primary-light file:text-primary file:text-xs file:font-semibold">

                            <button type="submit"
                                class="w-full mt-4 py-3 bg-success hover:bg-emerald-600 text-white font-bold rounded-full transition text-sm">
                                <i class="fa-solid fa-check mr-1"></i> Verifikasi & Mulai Sewa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-dashed border-border p-8 text-center text-sm text-text-light">
                <div class="text-4xl opacity-60 mb-2"><i class="fa-solid fa-inbox"></i></div>
                Tidak ada booking yang menunggu verifikasi.
            </div>
        @endforelse
    </div>

    <!-- Daftar transaksi aktif / selesai -->
    <h2 class="text-xs font-bold uppercase tracking-widest text-text-light mb-3 flex items-center gap-2">
        <i class="fa-solid fa-clipboard-list text-primary"></i> Data Rental
    </h2>

    <div class="space-y-3">
        @forelse ($transaksies as $trx)
            <div class="bg-white rounded-xl border border-border shadow-sm p-4">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 {{ $trx->status === 'selesai' ? 'bg-gray-100 text-gray-500' : 'bg-amber-100 text-amber-700' }} rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-car-side"></i>
                        </span>
                        <div>
                            <div class="font-bold text-sm">{{ $trx->car->nama }}</div>
                            <div class="text-[11px] text-text-light font-medium">{{ $trx->atas_nama }} •
                                {{ $trx->telepon }}</div>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full
                        {{ $trx->status === 'disewakan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                        {{ $trx->status === 'disewakan' ? 'Disewakan' : 'Selesai' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-x-3 gap-y-1 text-xs text-text-light font-medium mb-3">
                    <span><i class="fa-solid fa-calendar-days mr-1 w-3"></i>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</span>
                    <span><i class="fa-solid fa-hourglass mr-1 w-3"></i>{{ $trx->durasi_sewa }} hari</span>
                    <span class="col-span-2"><i class="fa-solid fa-money-bill mr-1 w-3"></i>Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center justify-between gap-2 border-t border-border pt-3">
                    @if ($trx->bukti_img)
                        <a href="{{ asset('storage/' . $trx->bukti_img) }}" target="_blank"
                            class="text-primary text-xs font-semibold hover:underline">
                            <i class="fa-solid fa-image mr-1"></i> Lihat Bukti
                        </a>
                    @else
                        <span class="text-xs text-text-light italic">Tanpa bukti foto</span>
                    @endif

                    @if ($trx->status === 'disewakan')
                        <form method="POST" action="{{ route('petugas.transaksi.selesai', $trx->id) }}"
                            onsubmit="return confirm('Selesaikan sewa ini? Mobil akan tersedia kembali.')">
                            @csrf
                            <button type="submit"
                                class="bg-success hover:bg-emerald-600 text-white px-4 py-2 rounded-full text-xs font-semibold transition">
                                <i class="fa-solid fa-flag-checkered mr-1"></i> Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-dashed border-border p-8 text-center text-sm text-text-light">
                Belum ada data rental.
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModal = (id) => {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };
            const closeModal = (el) => {
                el.classList.add('hidden');
                document.body.style.overflow = '';
            };

            document.querySelectorAll('.modal-open-btn').forEach(btn => {
                btn.addEventListener('click', () => openModal(btn.dataset.modal));
            });
            document.querySelectorAll('.modal-close-btn').forEach(btn => {
                btn.addEventListener('click', () => closeModal(btn.closest('.modal-overlay')));
            });
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) closeModal(overlay);
                });
            });
        });
    </script>
@endsection
