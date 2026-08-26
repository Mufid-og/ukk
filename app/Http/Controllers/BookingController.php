<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaksie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create(Car $car)
    {
        if ($car->status !== 'tersedia') {
            return redirect()->route('landing')->with('error', 'Mobil sedang tidak tersedia.');
        }

        return view('pages.user.booking', compact('car'));
    }

    public function store(Request $request, Car $car)
    {
        if ($car->status !== 'tersedia') {
            return redirect()->route('landing')->with('error', 'Mobil sudah dibooking orang lain.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'durasi_sewa' => 'required|integer|min:1|max:365',
        ]);

        $result = DB::transaction(function () use ($validated, $car) {
            $affected = Car::query()
                ->where('id', $car->id)
                ->where('status', 'tersedia')
                ->update(['status' => 'dibooking']);

            if (! $affected) {
                return false;
            }

            Transaksie::create([
                'id_car' => $car->id,
                'tanggal' => $validated['tanggal'],
                'telepon' => auth()->user()->telepone,
                'durasi_sewa' => $validated['durasi_sewa'],
                'total' => $car->harga * $validated['durasi_sewa'],
                'status' => 'pending',
                'atas_nama' => auth()->user()->nama,
            ]);

            return true;
        });

        if (! $result) {
            return redirect()->route('landing')->with('error', 'Mobil sudah dibooking orang lain.');
        }

        return redirect()->route('riwayat')->with('success', 'Booking berhasil! Menunggu verifikasi petugas.');
    }

    public function riwayat()
    {
        $transaksies = Transaksie::query()
            ->where('telepon', auth()->user()->telepone)
            ->with('car.kelas', 'car.brand')
            ->latest()
            ->get();

        return view('pages.user.riwayat', compact('transaksies'));
    }
}
