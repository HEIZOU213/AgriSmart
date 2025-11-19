<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Admin melihat SEMUA user kecuali dirinya sendiri
        $users = User::where('id', '!=', auth()->id())
                     ->orderBy('id', 'desc')
                     ->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // [FIXED] Validasi diubah dari 'nama' -> 'name'
        $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petani,konsumen',
        ]);

        User::create([
            'name' => $request->name, // [FIXED] Diubah dari $request->nama
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function show(string $id)
    {
        return $this->edit($id); // Redirect ke halaman edit
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            abort(403, 'Anda tidak dapat mengedit akun Anda sendiri dari sini.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // [FIXED] Validasi diubah dari 'nama' -> 'name'
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,petani,konsumen',
        ]);

        $user->name = $request->name; // [FIXED] Diubah dari $request->nama
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            abort(403, 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}