@extends('layouts.auth')

@section('title', 'Masuk')
@section('judul', 'Masuk ke Akun')

@section('form')
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-4">
            <label for="telepone" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Nomor
                Telepon</label>
            <input type="text" id="telepone" name="telepone" value="{{ old('telepone') }}" placeholder="081234567890"
                required
                class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-xs font-bold uppercase tracking-wide text-text-light mb-1.5">Password</label>
            <input type="password" id="password" name="password" placeholder="********" required
                class="w-full px-4 py-3 border-2 border-border rounded-xl text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
        </div>

        <button type="submit"
            class="w-full py-3.5 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition mt-2">
            Masuk
        </button>
    </form>
@endsection

@section('link-alternatif')
    <p class="text-center text-sm mt-5">
        Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-semibold">Daftar sekarang</a>
    </p>
@endsection
