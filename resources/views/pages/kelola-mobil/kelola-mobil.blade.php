@extends('layouts.app')

@section('title')
    Kelola Dashboard
@endsection
@section('content')
    @if (session('error'))
        <!-- Alert error -->
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <!-- Alert sukses -->
        <div
            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif
    <div class="p-6">

        <!-- Baris tab (ditambahkan data-tab) -->
        <div class="flex flex-wrap gap-2.5 mb-5">
            <button data-tab="kelas"
                class="tab-btn bg-primary text-white border-2 border-primary px-5 py-2.5 rounded-full text-sm font-semibold cursor-pointer transition">Kelas</button>
            <button data-tab="brand"
                class="tab-btn bg-white text-text border-2 border-border px-5 py-2.5 rounded-full text-sm font-semibold cursor-pointer transition hover:border-slate-300">Brand</button>
            <button data-tab="mobil"
                class="tab-btn bg-white text-text border-2 border-border px-5 py-2.5 rounded-full text-sm font-semibold cursor-pointer transition hover:border-slate-300">Mobil</button>
        </div>

        <!-- Wadah Utama Konten Tab -->
        <div id="tab-wrapper">
            <!-- TAB 1: KELAS (Aktif secara default) -->
            <div id="tab-kelas" class="tab-panel">
                <!-- SETUP TABLE KELAS DI SINI -->
                <div class="bg-white rounded-2xl border border-border shadow">
                    <div class="flex w-full justify-between">
                        <h1 class="p-5 font-bold">Daftar Kelas</h1>
                        <form method="POST" action="{{ route('post-kelas') }}" class="flex m-3 gap-3">
                            @csrf
                            <input type="text" name="kelas" placeholder="ketik kelas baru"
                                class="border rounded-2xl p-3">
                            <button
                                class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition">Tambah</button>
                        </form>
                    </div>
                    <table class="w-full border-collapse text-sm min-w-[800px]">
                        <thead>
                            <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nomor</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nama Kelas</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-text">
                            @foreach ($kelas as $kls)
                                <tr class="hover:bg-[#f8fafd] transition">
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $kls['kelas'] }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">
                                        <form action="{{ route('delete-kelas', $kls['id']) }}" method="POST"
                                            onsubmit="return confirm('apakah anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-5 py-2.5 bg-danger hover:bg-red-600 text-white rounded-full text-sm font-semibold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: BRAND (Sembunyi) -->
            <div id="tab-brand" class="tab-panel hidden">
                <!-- SETUP TABLE BRAND DI SINI -->
                <div class="bg-white rounded-2xl border border-border shadow">
                    <div class="flex w-full justify-between">
                        <h1 class="p-5 font-bold">Daftar Brand</h1>
                        <form method="POST" action="{{ route('post-brand') }}" class="flex m-3 gap-3">
                            @csrf
                            <input type="text" name="brand" placeholder="ketik brand baru"
                                class="border rounded-2xl p-3">
                            <button
                                class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition">Tambah</button>
                        </form>
                    </div>
                    <table class="w-full border-collapse text-sm min-w-[800px]">
                        <thead>
                            <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nomor</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Brand</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-text">
                            <!-- Baris 1: tersedia -->
                            @foreach ($brands as $brand)
                                <tr class="hover:bg-[#f8fafd] transition">
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $brand->brand }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">
                                        <form action="{{ route('delete-brand', $brand['id']) }}" method="POST"
                                            onsubmit="return confirm('apakah anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-5 py-2.5 bg-danger hover:bg-red-600 text-white rounded-full text-sm font-semibold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: MOBIL (Sembunyi) -->
            <div id="tab-mobil" class="tab-panel hidden">
                <!-- SETUP TABLE MOBIL DI SINI -->
                <div class="bg-white rounded-2xl border border-border shadow">
                    <div class="flex w-full justify-between">
                        <h1 class="p-5 font-bold">Daftar Mobil</h1>
                        <a href="{{ route('index-kelola-mobil-create') }}"
                            class="m-2.5 px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition">Tambah</a>
                    </div>
                    <table class="w-full border-collapse text-sm min-w-[800px]">
                        <thead>
                            <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nomor</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nama Mobil</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Kelas Mobil</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Brand Mobil</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Harga</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Status</th>
                                <th class="px-4 py-3.5 font-bold border-b-2 border-border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-text">
                            @foreach ($cars as $car)
                                <tr class="hover:bg-[#f8fafd] transition">
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $car->nama }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $car->kelas->kelas }}
                                    </td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $car->brand->brand }}
                                    </td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">Rp.
                                        {{ number_format($car->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $car->status }}</td>
                                    <td class="px-4 py-3.5 border-b border-border font-semibold">
                                        <div class="flex gap-2">
                                            <a href="{{ route('index-kelola-mobil-detail', $car->id) }}"
                                                class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition">
                                                Detail</a>
                                            @if ($car->status === 'tersedia')
                                                <form action="{{ route('delete-car', $car->id) }}" method="POST"
                                                    onsubmit="return confirm('apakah anda yakin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="px-5 py-2.5 bg-danger hover:bg-red-600 text-white rounded-full text-sm font-semibold transition">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.tab-btn');
            const panels = document.querySelectorAll('.tab-panel');

            // Fungsi utama untuk perpindahan tab
            function switchTab(targetTab) {
                const targetBtn = document.querySelector(`.tab-btn[data-tab="${targetTab}"]`);
                const targetPanel = document.getElementById(`tab-${targetTab}`);

                // Jika target tab tidak ditemukan, abaikan
                if (!targetBtn || !targetPanel) return;

                // 1. Reset gaya semua tombol
                buttons.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white', 'border-primary');
                    b.classList.add('bg-white', 'text-text', 'border-border');
                });

                // 2. Set gaya tombol aktif
                targetBtn.classList.add('bg-primary', 'text-white', 'border-primary');
                targetBtn.classList.remove('bg-white', 'text-text', 'border-border');

                // 3. Tampilkan panel yang dipilih & sembunyikan sisanya
                panels.forEach(panel => {
                    if (panel.id === `tab-${targetTab}`) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            }

            // Event listener klik tombol tab
            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetTab = btn.getAttribute('data-tab');

                    // Simpan ke URL Hash (misal: index.html#brand)
                    window.location.hash = targetTab;

                    switchTab(targetTab);
                });
            });

            // Cek URL Hash saat halaman dimuat / di-refresh
            const currentHash = window.location.hash.replace('#', '');
            if (currentHash) {
                switchTab(currentHash);
            }
        });
    </script>
@endsection
