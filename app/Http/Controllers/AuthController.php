<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller untuk login, registrasi, dan logout
class AuthController extends Controller
{
    // ---------- LOGIN ----------

    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Auth::attempt mencocokkan email dan password dengan tabel users
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            // Arahkan ke halaman awal sesuai role (admin, petugas, atau customer)
            return redirect()->route(Auth::user()->halamanAwal());
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    // ---------- REGISTRASI ----------

    public function formRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'max:100'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        // Registrasi mandiri selalu menjadi customer.
        // Akun admin dan petugas hanya dibuat lewat seeder atau menu Data Petugas.
        // Password otomatis di-hash oleh model User (casts 'hashed')
        User::create($data + ['role' => User::ROLE_CUSTOMER]);

        return redirect()->route('login')->with('sukses', 'Registrasi berhasil, silakan login.');
    }

    // ---------- LOGOUT ----------

    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session lama dan buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
