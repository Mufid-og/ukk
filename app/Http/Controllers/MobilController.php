<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $brands = Brand::all();
        $cars = Car::with(['kelas', 'brand'])->get();

        return view('pages.kelola-mobil.kelola-mobil', compact('kelas', 'brands', 'cars'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $brands = Brand::all();

        return view('pages.kelola-mobil.form', [
            'car' => null,
            'kelas' => $kelas,
            'brands' => $brands,
        ]);
    }

    public function indexMobilDetail($id)
    {
        $car = Car::query()->with('kelas', 'brand')->findOrFail($id);
        $kelas = Kelas::all();
        $brands = Brand::all();

        return view('pages.kelola-mobil.form', compact('car', 'kelas', 'brands'));
    }

    public function postKelas(Request $request)
    {
        $request->validate([
            'kelas' => 'required|max:15|min:1',
        ]);

        Kelas::create([
            'kelas' => $request->kelas,
        ]);

        return redirect('/kelola-mobil#kelas')->with('success', 'berhasil menambahkan kelas');
    }

    public function postBrand(Request $request)
    {
        $request->validate([
            'brand' => 'required|max:50|min:1',
        ]);

        Brand::create([
            'brand' => $request->brand,
        ]);

        return redirect('/kelola-mobil#brand')->with('success', 'berhasil menambahkan brand');
    }

    public function storeCar(Request $request)
    {
        $validated = $this->validateCar($request);

        $validated['img'] = $this->simpanGambar($request);

        if (! $validated['img']) {
            return back()->withInput()->with('error', 'Gambar mobil wajib diunggah.');
        }

        Car::create($validated);

        return redirect()->route('index-kelola-mobil')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function putCar(Request $request)
    {
        $request->validate(['id' => 'required|exists:cars,id']);

        $car = Car::findOrFail($request->input('id'));

        $validated = $this->validateCar($request);

        if ($gambarBaru = $this->simpanGambar($request)) {
            if ($car->img && Storage::disk('public')->exists($car->img)) {
                Storage::disk('public')->delete($car->img);
            }
            $validated['img'] = $gambarBaru;
        }

        $car->update($validated);

        return redirect()->route('index-kelola-mobil')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function deleteKelas($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        if (! $kelas) {
            return redirect('/kelola-mobil#kelas')->with('error', 'data tidak ditemukan');
        }

        $kelas->delete();

        return redirect('/kelola-mobil#kelas')->with('success', 'berhasil menghapus kelas');
    }

    public function deleteBrand($id)
    {
        $brand = Brand::where('id', $id)->first();

        if (! $brand) {
            return redirect('/kelola-mobil#brand')->with('error', 'data tidak ditemukan');
        }

        $brand->delete();

        return redirect('/kelola-mobil#brand')->with('success', 'berhasil menghapus brand');
    }

    public function deleteCar($id)
    {
        $car = Car::find($id);

        if (! $car) {
            return redirect()->route('index-kelola-mobil')->with('error', 'Mobil tidak ditemukan.');
        }

        if ($car->status !== 'tersedia') {
            return redirect()->route('index-kelola-mobil')->with('error', 'Mobil sedang dibooking/disewakan, tidak bisa dihapus.');
        }

        if ($car->img && Storage::disk('public')->exists($car->img)) {
            Storage::disk('public')->delete($car->img);
        }

        $car->delete();

        return redirect()->route('index-kelola-mobil')->with('success', 'Mobil berhasil dihapus.');
    }

    private function validateCar(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'warna' => 'required|string|max:150',
            'tahun' => 'required|string|digits:4',
            'transmisi' => 'required|string|max:100',
            'kursi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,disewakan,dibooking',
            'id_kelas' => 'required|exists:kelas,id',
            'id_brand' => 'required|exists:brands,id',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
    }

    private function simpanGambar(Request $request): ?string
    {
        if ($request->hasFile('img')) {
            return $request->file('img')->store('mobil', 'public');
        }

        return null;
    }
}
