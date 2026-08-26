@extends('layouts.app')

@section('title')
    Kelola Transaksi
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

    <div class="p-6">

        <!-- Filter status -->
        <div class="flex flex-wrap gap-2.5 mb-5">
            <a href="{{ route('admin.transaksi.index') }}"
                class="px-5 py-2.5 rounded-full text-sm font-semibold border-2 transition {{ request('status') ? 'bg-white text-text border-border hover:border-slate-300' : 'bg-primary text-white border-primary' }}">
                Semua</a>
            @foreach (['pending', 'disewakan', 'selesai'] as $st)
                <a href="{{ route('admin.transaksi.index', ['status' => $st]) }}"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold border-2 transition {{ request('status') === $st ? 'bg-primary text-white border-primary' : 'bg-white text-text border-border hover:border-slate-300' }}">
                    {{ ucfirst($st) }}</a>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-border shadow overflow-hidden">
            <div class="flex w-full justify-between items-center px-5 py-4 border-b border-border">
                <h1 class="font-bold">Daftar Transaksi ({{ $transaksies->count() }})</h1>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm min-w-[900px]">
                    <thead>
                        <tr class="bg-[#f8fafc] text-text-light text-[11px] uppercase tracking-wider text-left">
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">#</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Mobil</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Atas Nama</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Telepon</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Tanggal</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Durasi</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Total</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Bukti</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Status</th>
                            <th class="px-4 py-3.5 font-bold border-b-2 border-border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-text">
                        @forelse ($transaksies as $trx)
                            <tr class="hover:bg-[#f8fafd] transition">
                                <td class="px-4 py-3.5 border-b border-border font-semibold">{{ $trx->id }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->car?->nama ?? '-' }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->atas_nama }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->telepon }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3.5 border-b border-border">{{ $trx->durasi_sewa }} hari</td>
                                <td class="px-4 py-3.5 border-b border-border font-semibold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3.5 border-b border-border">
                                    @if ($trx->bukti_img)
                                        <a href="{{ asset('storage/' . $trx->bukti_img) }}" target="_blank"
                                            class="text-primary hover:underline font-semibold"><i class="fa-solid fa-image"></i> Lihat</a>
                                    @else
                                        <span class="text-text-light italic">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 border-b border-border">
                                    <span
                                        class="text-[11px] font-bold uppercase px-2.5 py-1 rounded-full
                                        {{ $trx->status === 'pending' ? 'bg-sky-100 text-sky-800 border border-sky-200' : '' }}
                                        {{ $trx->status === 'disewakan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                                        {{ $trx->status === 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 border-b border-border">
                                    <form action="{{ route('admin.transaksi.destroy', $trx) }}" method="POST"
                                        onsubmit="return confirm('Hapus transaksi ini? Status mobil akan dikembalikan ke tersedia jika masih aktif.')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-4 py-2 bg-danger hover:bg-red-600 text-white rounded-full text-xs font-semibold transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-10 text-center text-text-light">Tidak ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
