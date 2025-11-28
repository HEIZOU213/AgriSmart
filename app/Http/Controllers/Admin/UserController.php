<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Halaman Utama: Pilihan Kategori Akun (Box Menu)
     */
    public function index()
    {
        // Hitung jumlah untuk ditampilkan di badge
        $countPetani = User::where('role', 'petani')->count();
        $countKonsumen = User::where('role', 'konsumen')->count();

        return view('admin.users.index', compact('countPetani', 'countKonsumen'));
    }

    /**
     * Halaman Khusus Daftar Petani
     */
    public function listPetani()
    {
        $users = User::where('role', 'petani')->orderBy('created_at', 'desc')->paginate(12);
        $title = 'Daftar Mitra Petani';
        $roleType = 'petani'; // Untuk styling warna hijau
        
        return view('admin.users.list', compact('users', 'title', 'roleType'));
    }

    /**
     * Halaman Khusus Daftar Konsumen
     */
    public function listKonsumen()
    {
        $users = User::where('role', 'konsumen')->orderBy('created_at', 'desc')->paginate(12);
        $title = 'Daftar Konsumen';
        $roleType = 'konsumen'; // Untuk styling warna kuning
        
        return view('admin.users.list', compact('users', 'title', 'roleType'));
    }

    // --- CRUD Functions (Create, Store, Edit, Update, Destroy) Tetap Sama ---

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petani,konsumen',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect kembali ke halaman list yang sesuai
        if($request->role == 'petani') return redirect()->route('admin.users.petani')->with('success', 'Akun Petani berhasil dibuat.');
        if($request->role == 'konsumen') return redirect()->route('admin.users.konsumen')->with('success', 'Akun Konsumen berhasil dibuat.');
        
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function show(string $id)
    {
        return $this->edit($id);
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,petani,konsumen',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Redirect cerdas kembali ke list yang sesuai
        if($user->role == 'petani') return redirect()->route('admin.users.petani')->with('success', 'Data Petani diperbarui.');
        if($user->role == 'konsumen') return redirect()->route('admin.users.konsumen')->with('success', 'Data Konsumen diperbarui.');

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            abort(403, 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $role = $user->role; // Simpan role sebelum dihapus untuk redirect
        $user->delete();

        if($role == 'petani') return redirect()->route('admin.users.petani')->with('success', 'Akun Petani dihapus.');
        if($role == 'konsumen') return redirect()->route('admin.users.konsumen')->with('success', 'Akun Konsumen dihapus.');

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}