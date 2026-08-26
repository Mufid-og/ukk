<?php

namespace App\Http\Controllers;

use App\Models\Transaksie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaksies = Transaksie::query()
            ->with('car.brand')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->latest()
            ->get();

        return view('pages.admin.transaksi', compact('transaksies'));
    }

    public function destroy(Transaksie $transaksie)
    {
        DB::transaction(function () use ($transaksie) {
            if ($transaksie->status !== 'selesai') {
                $transaksie->car?->update(['status' => 'tersedia']);
            }

            if ($transaksie->bukti_img) {
                Storage::disk('public')->delete($transaksie->bukti_img);
            }

            $transaksie->delete();
        });

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
