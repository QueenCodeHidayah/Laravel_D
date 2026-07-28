<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user kecuali admin yang sedang login
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // =========================================================================
    // TAMBAHAN BARU: Menampilkan Halaman Form Tambah Akun (Admin)
    // =========================================================================
    public function create()
    {
        return view('admin.users.create');
    }

    // =========================================================================
    // TAMBAHAN BARU: Memproses Simpan Akun Baru ke Database
    // =========================================================================
    public function store(Request $request)
    {
        // Validasi input data akun baru
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8', // Pas buat akun baru, password wajib diisi
            'role' => 'required|in:admin,user,kasubag', // Memastikan role yang dipilih valid
        ]);

        // Daftarkan user baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash aman otomatis
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun baru berhasil didaftarkan!');
    }

    // Menampilkan halaman edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Menyimpan perubahan (Nama, Email, Password)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8', 
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Cek apakah Admin mengisi kotak password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Data user ' . $user->name . ' berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}