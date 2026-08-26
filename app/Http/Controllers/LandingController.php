<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Kelas;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $brands = Brand::query()
            ->when($request->filled('kelas'), fn ($query) => $query->where('id_kelas', $request->input('kelas')))
            ->get();

        $cars = Car::with(['kelas', 'brand'])
            ->when($request->filled('kelas'), fn ($query) => $query->where('id_kelas', $request->input('kelas')))
            ->when($request->filled('brand'), fn ($query) => $query->where('id_brand', $request->input('brand')))
            ->orderBy('nama')
            ->get();

        return view('pages.landing', compact('kelas', 'brands', 'cars'));
    }
}
