<div id="{{ $modalId }}" class="modal-overlay hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg">{{ $judul }}</h3>
            <button type="button" class="modal-close-btn text-text-light hover:text-danger text-xl w-8 h-8"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>

        <form method="POST" action="{{ $aksi }}">
            @csrf
            @if ($metode === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="{{ $modalId }}-nama" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Nama
                    Lengkap</label>
                <input type="text" id="{{ $modalId }}-nama" name="nama" value="{{ old('nama', $target->nama ?? '') }}" required
                    class="w-full px-4 py-2.5 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
            </div>

            <div class="mb-4">
                <label for="{{ $modalId }}-username"
                    class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Username</label>
                <input type="text" id="{{ $modalId }}-username" name="username" value="{{ old('username', $target->username ?? '') }}"
                    required
                    class="w-full px-4 py-2.5 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
            </div>

            <div class="mb-4">
                <label for="{{ $modalId }}-telepon"
                    class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">No. Telepon</label>
                <input type="tel" id="{{ $modalId }}-telepon" name="telepone" value="{{ old('telepone', $target->telepone ?? '') }}"
                    required
                    class="w-full px-4 py-2.5 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
            </div>

            <div class="mb-4">
                <label for="{{ $modalId }}-role" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Role</label>
                <select id="{{ $modalId }}-role" name="role"
                    class="w-full px-4 py-2.5 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                    @foreach (['admin', 'petugas', 'user'] as $role)
                        <option value="{{ $role }}" {{ old('role', $target->role ?? 'user') === $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="{{ $modalId }}-password"
                    class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">
                    Password {{ $target ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input type="password" id="{{ $modalId }}-password" name="password" placeholder="Minimal 6 karakter"
                    {{ $target ? '' : 'required minlength="6"' }}
                    class="w-full px-4 py-2.5 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
            </div>

            <button type="submit"
                class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition text-sm">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan
            </button>
        </form>
    </div>
</div>
