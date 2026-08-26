<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaksie;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalMobil' => Car::count(),
            'mobilTersedia' => Car::where('status', 'tersedia')->count(),
            'transaksiPending' => Transaksie::where('status', 'pending')->count(),
            'transaksiAktif' => Transaksie::where('status', 'disewakan')->count(),
        ];

        $transaksies = Transaksie::with('car')->latest()->limit(5)->get();

        return view('pages.dashboard', array_merge($stats, ['transaksies' => $transaksies]));
    }
}
