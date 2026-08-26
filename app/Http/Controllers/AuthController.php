<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepone' => 'required|string|max:20|unique:users,telepone',
            'password' => 'required|string|min:6',
        ], [
            'telepone.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        $user = User::create([
            'username' => $validated['telepone'],
            'nama' => $validated['nama'],
            'telepone' => $validated['telepone'],
            'password' => $validated['password'],
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('landing')->with('success', 'Registrasi berhasil! Silakan booking mobil Anda.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'telepone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt(['telepone' => $credentials['telepone'], 'password' => $credentials['password']])) {
            return back()->with('error', 'Nomor telepon atau password salah.')->onlyInput('telepone');
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin' => redirect()->route('index-dashboard'),
            'petugas' => redirect()->route('petugas.transaksi.index'),
            default => redirect()->route('landing'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
