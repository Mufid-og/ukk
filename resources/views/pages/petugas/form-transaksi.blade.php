@extends('layouts.mobile')

@section('title', 'Input Transaksi Baru')

@section('content')
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            <div class="flex items-center gap-2.5 mb-1"><i class="fa-solid fa-circle-exclamation"></i>
                <strong>Periksa kembali:</strong></div>
            <ul class="list-disc pl-9 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-border shadow-sm p-5 mb-5">
        <h1 class="font-bold mb-1">Input Transaksi Baru</h1>
        <p class="text-xs text-text-light mb-4">Untuk penyewa yang tidak booking lewat website.</p>

        <!-- Info mobil terpilih -->
        <div id="infoMobil" class="hidden bg-primary-light text-primary-dark text-sm font-semibold px-4 py-3 rounded-xl mb-5 inline-flex items-center gap-2 w-full">
            <i class="fa-solid fa-van-shuttle"></i> <span id="infoMobilText"></span>
        </div>

        <form method="POST" action="{{ route('petugas.transaksi.store') }}" enctype="multipart/form-data" id="formTransaksi">
            @csrf

            <!-- Pilih mobil -->
            <label for="id_car" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Mobil</label>
            <select id="id_car" name="id_car" required
                class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition mb-4">
                <option value="">— Pilih Mobil —</option>
                @foreach ($mobilTersedia as $mobil)
                    <option value="{{ $mobil->id }}" data-harga="{{ $mobil->harga }}"
                        {{ old('id_car') == $mobil->id ? 'selected' : '' }}>
                        {{ $mobil->nama }} ({{ $mobil->brand->brand }}) - Rp {{ number_format($mobil->harga, 0, ',', '.') }}/hari
                    </option>
                @endforeach
            </select>

            <!-- Atas nama -->
            <label for="atas_nama" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Atas Nama</label>
            <input type="text" id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}" placeholder="Nama penyewa"
                required
                class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition mb-4">

            <!-- Telepon -->
            <label for="telepon" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">No.
                Telepon</label>
            <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}" placeholder="081234567890" required
                class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition mb-4">

            <!-- Tanggal & durasi -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label for="tanggal" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                </div>
                <div>
                    <label for="durasi_sewa"
                        class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Durasi (hari)</label>
                    <input type="number" id="durasi_sewa" name="durasi_sewa" min="1" max="365" value="{{ old('durasi_sewa', 1) }}"
                        required
                        class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                </div>
            </div>

            <!-- Bukti foto (opsional saat input manual) -->
            <label for="bukti_img" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Foto Bukti Penyewaan
                <span class="normal-case font-medium">(opsional)</span></label>
            <input type="file" id="bukti_img" name="bukti_img" accept="image/*"
                class="w-full px-3 py-2.5 border-2 border-border rounded-xl text-sm bg-[#fafbfc] outline-none focus:border-primary transition file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-primary-light file:text-primary file:text-xs file:font-semibold mb-4">

            <!-- Kotak total -->
            <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl px-4 py-4 flex items-center justify-between font-bold mb-5">
                <span>Total Biaya</span>
                <span class="text-xl text-accent" id="totalBiaya">Rp 0</span>
            </div>

            <button type="submit"
                class="w-full py-3.5 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectCar = document.getElementById('id_car');
            const durasiInput = document.getElementById('durasi_sewa');
            const totalEl = document.getElementById('totalBiaya');
            const infoMobil = document.getElementById('infoMobil');
            const infoMobilText = document.getElementById('infoMobilText');

            function formatRupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka));
            }

            function refresh() {
                const opt = selectCar.options[selectCar.selectedIndex];
                const harga = parseFloat(opt?.dataset.harga || 0);
                const durasi = parseInt(durasiInput.value) || 0;

                totalEl.textContent = formatRupiah(harga * durasi);

                if (selectCar.value) {
                    infoMobil.classList.remove('hidden');
                    infoMobilText.textContent = opt.textContent;
                } else {
                    infoMobil.classList.add('hidden');
                }
            }

            selectCar.addEventListener('change', refresh);
            durasiInput.addEventListener('input', refresh);
            refresh();
        });
    </script>
@endsection
