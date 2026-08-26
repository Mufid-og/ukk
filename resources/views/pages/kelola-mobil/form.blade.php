@extends('layouts.app')

@section('title')
    {{ $car ? 'Edit Mobil' : 'Tambah Mobil' }}
@endsection

@section('content')
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5 m-6 mb-0">
            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5 m-6 mb-0">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="w-full mx-auto p-6">
        <div class="bg-white rounded-2xl border border-border shadow p-6">

            <h2 class="text-lg font-bold text-text mb-4 border-b border-border pb-2">
                {{ $car ? 'Edit Mobil: ' . $car->nama : 'Tambah Mobil Baru' }}
            </h2>

            <form method="POST"
                action="{{ $car ? route('put-car') : route('post-car') }}"
                enctype="multipart/form-data" id="formMobil">
                @csrf
                @if ($car)
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $car->id }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nama Mobil -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-text-light mb-1">Nama Mobil</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $car->nama ?? '') }}" required
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Warna -->
                    <div>
                        <label for="warna" class="block text-sm font-semibold text-text-light mb-1">Warna</label>
                        <input type="text" id="warna" name="warna" value="{{ old('warna', $car->warna ?? '') }}" required
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label for="tahun" class="block text-sm font-semibold text-text-light mb-1">Tahun</label>
                        <input type="number" id="tahun" name="tahun" min="1990" max="2100"
                            value="{{ old('tahun', $car->tahun ?? date('Y')) }}" required
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Transmisi -->
                    <div>
                        <label for="transmisi" class="block text-sm font-semibold text-text-light mb-1">Transmisi</label>
                        <select id="transmisi" name="transmisi"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            @foreach (['Automatic', 'Manual'] as $t)
                                <option value="{{ $t }}" {{ old('transmisi', $car->transmisi ?? 'Automatic') === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kursi -->
                    <div>
                        <label for="kursi" class="block text-sm font-semibold text-text-light mb-1">Jumlah Kursi</label>
                        <input type="number" id="kursi" name="kursi" min="1" value="{{ old('kursi', $car->kursi ?? 5) }}" required
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-text-light mb-1">Harga (per hari)</label>
                        <input type="number" id="harga" name="harga" min="0" step="1000"
                            value="{{ old('harga', $car->harga ?? '') }}" required
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="id_kelas" class="block text-sm font-semibold text-text-light mb-1">Kelas</label>
                        <select id="id_kelas" name="id_kelas"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $kls)
                                <option value="{{ $kls->id }}" {{ old('id_kelas', $car->id_kelas ?? '') == $kls->id ? 'selected' : '' }}>
                                    {{ $kls->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="id_brand" class="block text-sm font-semibold text-text-light mb-1">Brand</label>
                        <select id="id_brand" name="id_brand"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Pilih Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('id_brand', $car->id_brand ?? '') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-text-light mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            @foreach (['tersedia', 'disewakan', 'dibooking'] as $st)
                                <option value="{{ $st }}" {{ old('status', $car->status ?? 'tersedia') === $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label for="img" class="block text-sm font-semibold text-text-light mb-1">
                            Gambar Mobil {{ $car ? '(kosongkan jika tidak diubah)' : '' }}
                        </label>
                        <input type="file" id="img" name="img" accept="image/*" {{ $car ? '' : 'required' }}
                            class="w-full px-3 py-2 border border-border rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:bg-primary-light file:text-primary file:text-xs file:font-semibold" />
                    </div>
                </div>

                @if ($car?->img && str_starts_with($car->img, 'mobil/'))
                    <div class="mt-4">
                        <span class="block text-sm font-semibold text-text-light mb-1.5">Gambar saat ini:</span>
                        <img src="{{ asset('storage/' . $car->img) }}" alt="{{ $car->nama }}"
                            class="h-40 w-auto object-cover rounded-xl border border-border" />
                    </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="mt-6 flex flex-wrap gap-3 border-t border-border pt-6">
                    <button type="submit"
                        class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition shadow-md">
                        <i class="fa-regular fa-floppy-disk mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('index-kelola-mobil') }}"
                        class="px-6 py-2.5 border border-border hover:border-slate-300 text-text-light hover:text-text rounded-full text-sm font-semibold transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
