@extends('layouts.app')

@section('title')
    Kelola User
@endsection

@section('content')
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5 m-6 mb-0">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2.5 m-6 mb-0">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 m-6 mb-0">
            <div class="flex items-center gap-2.5 mb-1"><i class="fa-solid fa-circle-exclamation"></i>
                <strong>Periksa kembali:</strong></div>
            <ul class="list-disc pl-9">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6">

        <!-- Card pembungkus table -->
        <div class="bg-white rounded-2xl border border-border shadow overflow-hidden">
            <div class="flex w-full justify-between items-center px-5 py-4 border-b border-border">
                <h1 class="font-bold">Daftar User ({{ $users->count() }})</h1>
                <button type="button" data-modal="modal-tambah"
                    class="modal-open-btn px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-full text-sm font-semibold transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Tambah User
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm min-w-[800px]">
                    <thead>
                        <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nomor</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Nama</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Username</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Telepon</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Role</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-text">
                        @foreach ($users as $user)
                            <tr class="hover:bg-[#f8fafd] transition">
                                <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $user->nama }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $user->username }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $user->telepone }}</td>
                                <td class="px-4 py-3.5 border-b border-border">
                                    <span
                                        class="text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full
                                        {{ $user->role === 'admin' ? 'bg-[#ede7f6] text-purple-800 border border-purple-200' : '' }}
                                        {{ $user->role === 'petugas' ? 'bg-sky-100 text-sky-800 border border-sky-200' : '' }}
                                        {{ $user->role === 'user' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 border-b border-border">
                                    <div class="flex gap-2">
                                        <button type="button" data-modal="modal-edit-{{ $user->id }}"
                                            class="modal-open-btn px-4 py-2 bg-warning hover:bg-amber-500 text-white rounded-full text-xs font-semibold transition">Edit</button>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.user.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('apakah anda yakin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-4 py-2 bg-danger hover:bg-red-600 text-white rounded-full text-xs font-semibold transition">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal edit user -->
                            @include('pages.admin._form-user', [
                                'modalId' => 'modal-edit-' . $user->id,
                                'judul' => 'Edit User',
                                'aksi' => route('admin.user.update', $user),
                                'target' => $user,
                                'metode' => 'PUT',
                            ])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal tambah user -->
    @include('pages.admin._form-user', [
        'modalId' => 'modal-tambah',
        'judul' => 'Tambah User',
        'aksi' => route('admin.user.store'),
        'target' => null,
        'metode' => 'POST',
    ])

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
