@extends('layouts.landing')

@section('title', 'Form Penyewaan')

@section('content')
    <div class="max-w-lg mx-auto p-6">
        @if (session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                <div class="flex items-center gap-2.5 mb-1"><i class="fa-solid fa-circle-exclamation"></i>
                    <strong>Periksa kembali:</strong></div>
                <ul class="list-disc pl-9">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-border shadow-lg p-6 sm:p-7">

            <h2 class="text-xl font-bold mb-5">Form Penyewaan</h2>

            <!-- Info mobil terpilih -->
            <div
                class="bg-primary-light text-primary-dark text-sm font-semibold px-4 py-3 rounded-xl mb-6 inline-flex items-center gap-2 w-full">
                <i class="fa-solid fa-van-shuttle"></i> {{ $car->nama }} ({{ $car->brand->brand }}) -
                Rp {{ number_format($car->harga, 0, ',', '.') }}/hari
            </div>

            <form method="POST" action="{{ route('booking.store', $car->id) }}" id="formBooking">
                @csrf

                <!-- Tanggal sewa -->
                <div class="mb-4">
                    <label for="tanggal"
                        class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Tanggal Sewa</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                </div>

                <!-- Durasi -->
                <div class="mb-4">
                    <label for="durasi_sewa"
                        class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Durasi (hari)</label>
                    <input type="number" id="durasi_sewa" name="durasi_sewa" min="1" max="365" value="1" required
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                </div>

                <!-- Kotak total -->
                <div
                    class="bg-emerald-50 border-2 border-emerald-200 rounded-xl px-4 py-4 flex items-center justify-between font-bold mb-5">
                    <span>Total Biaya (Full Payment)</span>
                    <span class="text-xl text-accent" id="totalBiaya">Rp {{ number_format($car->harga, 0, ',', '.') }}</span>
                </div>

                <!-- Tombol konfirmasi -->
                <button type="submit"
                    class="w-full py-3.5 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-key"></i> Konfirmasi Booking & Bayar
                </button>
            </form>

            <a href="{{ route('landing') }}" class="block text-center mt-4 text-primary font-medium text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const harga = @js($car->harga);
            const durasiInput = document.getElementById('durasi_sewa');
            const totalEl = document.getElementById('totalBiaya');

            function formatRupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka));
            }

            function hitungTotal() {
                const durasi = parseInt(durasiInput.value) || 0;
                totalEl.textContent = formatRupiah(harga * durasi);
            }

            durasiInput.addEventListener('input', hitungTotal);
            hitungTotal();
        });
    </script>
@endsection
