<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::query()->latest()->get();

        return view('pages.admin.kelola-user', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nama' => 'required|string|max:255',
            'telepone' => 'required|string|max:20|unique:users,telepone',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,user',
        ]);

        User::create($validated);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'nama' => 'required|string|max:255',
            'telepone' => 'required|string|max:20|unique:users,telepone,'.$user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petugas,user',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
