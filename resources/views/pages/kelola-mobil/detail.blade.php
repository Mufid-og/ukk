@extends('layouts.app')

@section('title')
    Detail Mobil
@endsection

@section('content')
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="w-full mx-auto p-6">
        <div class="bg-white rounded-2xl border border-border shadow p-6">

            <h2 class="text-lg font-bold text-text mb-4 border-b border-border pb-2">Tambah Mobil Baru</h2>

            <!-- ========================================== -->
            <!-- TEMPAT ERROR VALIDASI (bisa diisi manual)   -->
            <!-- ========================================== -->
            <div id="errorContainer"
                class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5 mb-4">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul id="errorList" class="list-disc pl-4">
                    <!-- error akan dimasukkan oleh JS jika diperlukan -->
                </ul>
            </div>

            <!-- ========================================== -->
            <!-- FORM                                      -->
            <!-- ========================================== -->
            <form id="formTambah" method="POST" action="#" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="dummy_token" />
                <input type="hidden" name="_method" value="POST" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nama Mobil -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-text-light mb-1">Nama Mobil</label>
                        <input type="text" id="nama" name="nama" value="{{ $car->nama }}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Warna -->
                    <div>
                        <label for="warna" class="block text-sm font-semibold text-text-light mb-1">Warna</label>
                        <input type="text" id="warna" name="warna" value="{{ $car->warna}}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label for="tahun" class="block text-sm font-semibold text-text-light mb-1">Tahun</label>
                        <input type="text" id="tahun" name="tahun" value="{{ $car->tahun }}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Transmisi -->
                    <div>
                        <label for="transmisi" class="block text-sm font-semibold text-text-light mb-1">Transmisi</label>
                        <input type="text" id="transmisi" name="transmisi" value="{{ $car->transmisi }}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Kursi -->
                    <div>
                        <label for="kursi" class="block text-sm font-semibold text-text-light mb-1">Jumlah Kursi</label>
                        <input type="number" id="kursi" name="kursi" value="{{ $car->kursi }}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-text-light mb-1">Harga (per
                            hari)</label>
                        <input type="text" id="harga" name="harga" value="{{ $car->kursi }}"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="id_kelas" class="block text-sm font-semibold text-text-light mb-1">Kelas</label>
                        <select id="id_kelas" name="id_kelas"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            @foreach ($kelas as $kls)
                            @continue($car->kelas === $kls->kelas)
                            <option value="">{{ $kls->kelas }}</option>
                            @endforeach
                            <option value="" selected >Hatchback</option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="id_brand" class="block text-sm font-semibold text-text-light mb-1">Brand</label>
                        <select id="id_brand" name="id_brand"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Pilih Brand</option>
                            <option value="1">Toyota</option>
                            <option value="2">Honda</option>
                            <option value="3">Mazda</option>
                            <option value="4">Suzuki</option>
                            <option value="5">Nissan</option>
                            <option value="6">BMW</option>
                            <option value="7">Mercedes</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-text-light mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full border border-border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="tersedia">Tersedia</option>
                            <option value="disewa">Disewa</option>
                            <option value="perbaikan">Perbaikan</option>
                        </select>
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- BAGIAN UPLOAD GAMBAR (dengan preview)       -->
                <!-- ========================================== -->
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-text-light mb-1">Gambar Mobil</label>

                    <!-- Container preview gambar -->
                    <div id="gambarContainer"
                        class="flex overflow-x-auto gap-2 p-0 h-48 items-stretch gallery-scroll border border-dashed border-border rounded-xl p-2 bg-[#f8fafc]">
                        <!-- Preview akan muncul di sini via JS -->
                    </div>

                    <!-- Tombol tambah gambar -->
                    <div class="mt-3">
                        <label for="inputGambar"
                            class="cursor-pointer inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                            <i class="fa-regular fa-image"></i> Pilih Gambar (bisa banyak)
                        </label>
                        <input type="file" id="inputGambar" name="gambar_baru[]" accept="image/*" multiple
                            class="hidden" onchange="tambahPreviewGambar(event)">
                    </div>
                    <p class="text-xs text-text-light mt-1">* Format: jpg, jpeg, png. Maks 2MB per gambar.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-6 flex flex-wrap gap-3 border-t border-border pt-6">
                    <button type="submit"
                        class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition shadow-md">
                        <i class="fa-regular fa-floppy-disk mr-2"></i> Simpan
                    </button>
                    <a href="#"
                        class="px-6 py-2.5 border border-border hover:border-slate-300 text-text-light hover:text-text rounded-full text-sm font-semibold transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>


@endsection

<script>
    let newImageCounter = 0;

    function tambahPreviewGambar(event) {
        const files = event.target.files;
        const container = document.getElementById('gambarContainer');

        for (let file of files) {
            // Validasi ukuran (opsional)
            if (file.size > 2 * 1024 * 1024) {
                alert('Gambar ' + file.name + ' melebihi 2MB. File ini dilewati.');
                continue;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const uniqueId = 'preview-' + (newImageCounter++);
                const div = document.createElement('div');
                div.className = 'relative flex-shrink-0 h-full min-w-[150px] border rounded-lg overflow-hidden';
                div.id = 'gambar-' + uniqueId;

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-full w-full object-cover';
                img.alt = 'preview';

                // Tombol hapus preview (hanya menghilangkan dari DOM)
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className =
                    'absolute top-1 right-1 bg-danger text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 shadow-lg';
                btn.innerHTML = '×';
                btn.onclick = function() {
                    this.parentElement.remove();
                };

                div.appendChild(img);
                div.appendChild(btn);
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
        // Reset input agar bisa pilih file yang sama lagi
        event.target.value = '';
    }

    // ==========================================
    // Opsional: validasi client-side sebelum submit
    // ==========================================
    document.getElementById('formTambah').addEventListener('submit', function(e) {
        const errorContainer = document.getElementById('errorContainer');
        const errorList = document.getElementById('errorList');
        const errors = [];

        // Ambil nilai input
        const nama = document.getElementById('nama').value.trim();
        const warna = document.getElementById('warna').value.trim();
        const tahun = document.getElementById('tahun').value.trim();
        const transmisi = document.getElementById('transmisi').value.trim();
        const kursi = document.getElementById('kursi').value.trim();
        const harga = document.getElementById('harga').value.trim();
        const kelas = document.getElementById('id_kelas').value;
        const brand = document.getElementById('id_brand').value;
        const status = document.getElementById('status').value;

        // Validasi sederhana
        if (!nama) errors.push('Nama mobil harus diisi.');
        if (!warna) errors.push('Warna harus diisi.');
        if (!tahun || isNaN(tahun) || tahun.length !== 4) errors.push('Tahun harus berupa 4 digit angka.');
        if (!transmisi) errors.push('Transmisi harus diisi.');
        if (!kursi || isNaN(kursi) || parseInt(kursi) < 1) errors.push('Kursi harus angka positif.');
        if (!harga || isNaN(harga) || parseFloat(harga) <= 0) errors.push('Harga harus angka lebih dari 0.');
        if (!kelas) errors.push('Kelas harus dipilih.');
        if (!brand) errors.push('Brand harus dipilih.');
        if (!status) errors.push('Status harus dipilih.');

        if (errors.length > 0) {
            e.preventDefault();
            errorList.innerHTML = errors.map(err => '<li>' + err + '</li>').join('');
            errorContainer.classList.remove('hidden');
            // Scroll ke error
            errorContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        } else {
            errorContainer.classList.add('hidden');
            // Jika ingin melanjutkan submit, biarkan saja
            // Jika ingin menampilkan pesan sukses, bisa tambahkan di sini
        }
    });
</script>
