<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaksie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasTransaksiController extends Controller
{
    public function index()
    {
        $pending = Transaksie::query()
            ->where('status', 'pending')
            ->with('car.kelas', 'car.brand')
            ->latest()
            ->get();

        $transaksies = Transaksie::query()
            ->whereIn('status', ['disewakan', 'selesai'])
            ->with('car.brand')
            ->latest()
            ->get();

        $statHariIni = Transaksie::query()->whereDate('created_at', today())->count();
        $statDisewakan = Transaksie::query()->where('status', 'disewakan')->count();
        $statPending = $pending->count();

        $mobilTersedia = Car::with(['kelas', 'brand'])->where('status', 'tersedia')->orderBy('nama')->get();

        return view('pages.petugas.transaksi', compact(
            'pending',
            'transaksies',
            'statHariIni',
            'statDisewakan',
            'statPending',
            'mobilTersedia',
        ));
    }

    public function create()
    {
        $mobilTersedia = Car::with(['kelas', 'brand'])->where('status', 'tersedia')->orderBy('nama')->get();

        return view('pages.petugas.form-transaksi', compact('mobilTersedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_car' => 'required|exists:cars,id',
            'atas_nama' => 'required|string|max:150',
            'telepon' => 'required|string|max:50',
            'tanggal' => 'required|date|after_or_equal:today',
            'durasi_sewa' => 'required|integer|min:1|max:365',
            'bukti_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $car = Car::findOrFail($validated['id_car']);

            $affected = Car::query()
                ->where('id', $car->id)
                ->where('status', 'tersedia')
                ->update(['status' => 'disewakan']);

            if (! $affected) {
                abort(422, 'Mobil sudah tidak tersedia.');
            }

            $path = null;
            if ($request->hasFile('bukti_img')) {
                $path = $request->file('bukti_img')->store('bukti-sewa', 'public');
            }

            Transaksie::create([
                'id_car' => $car->id,
                'tanggal' => $validated['tanggal'],
                'telepon' => $validated['telepon'],
                'durasi_sewa' => $validated['durasi_sewa'],
                'total' => $car->harga * $validated['durasi_sewa'],
                'status' => 'disewakan',
                'atas_nama' => $validated['atas_nama'],
                'bukti_img' => $path,
            ]);
        });

        return redirect()->route('petugas.transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function verify(Request $request, Transaksie $transaksie)
    {
        if ($transaksie->status !== 'pending') {
            return redirect()->route('petugas.transaksi.index')->with('error', 'Transaksi sudah diverifikasi.');
        }

        $request->validate([
            'bukti_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::transaction(function () use ($request, $transaksie) {
            $car = Car::findOrFail($transaksie->id_car);

            $affected = Car::query()
                ->where('id', $car->id)
                ->where('status', 'dibooking')
                ->update(['status' => 'disewakan']);

            if (! $affected) {
                abort(422, 'Status mobil sudah berubah.');
            }

            $path = $request->file('bukti_img')->store('bukti-sewa', 'public');

            $transaksie->update([
                'status' => 'disewakan',
                'bukti_img' => $path,
            ]);
        });

        return redirect()->route('petugas.transaksi.index')->with('success', 'Booking diverifikasi, mobil kini disewakan.');
    }

    public function finish(Transaksie $transaksie)
    {
        if ($transaksie->status !== 'disewakan') {
            return redirect()->route('petugas.transaksi.index')->with('error', 'Transaksi tidak bisa diselesaikan.');
        }

        DB::transaction(function () use ($transaksie) {
            $transaksie->update(['status' => 'selesai']);
            Car::where('id', $transaksie->id_car)->update(['status' => 'tersedia']);
        });

        return redirect()->route('petugas.transaksi.index')->with('success', 'Sewa selesai, mobil tersedia kembali.');
    }
}
