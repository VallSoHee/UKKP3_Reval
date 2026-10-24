<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// Dasar CRUD akun pengguna. Dipakai oleh CustomerController dan PetugasController,
// yang hanya perlu menentukan $role dan $label.
abstract class PenggunaController extends Controller
{
    protected string $role;    // 'customer' atau 'petugas'
    protected string $label;   // teks yang tampil di halaman

    // Awalan nama rute, misalnya 'admin.customer', 'petugas.customer', atau 'admin.petugas'
    private function rute()
    {
        return auth()->user()->role . '.' . $this->role;
    }

    // Selalu cari di dalam role yang sesuai, supaya akun role lain tidak bisa diubah lewat halaman ini
    private function cari($id)
    {
        return User::where('role', $this->role)->findOrFail($id);
    }

    private function tampil($view, array $data = [])
    {
        return view('pengguna.' . $view, $data + [
            'role'  => $this->role,
            'label' => $this->label,
            'rute'  => $this->rute(),
        ]);
    }

    public function index(Request $request)
    {
        $query = User::where('role', $this->role)->latest();

        // Pencarian berdasarkan nama atau email
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%$cari%")
                  ->orWhere('email', 'like', "%$cari%");
            });
        }

        $users = $query->simplePaginate(10)->withQueryString();

        return $this->tampil('index', compact('users'));
    }

    public function create()
    {
        return $this->tampil('create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'max:100'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ], $this->pesan());

        User::create($data + ['role' => $this->role]);

        return redirect()->route($this->rute() . '.index')
            ->with('sukses', $this->label . ' berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->cari($id);

        return $this->tampil('edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = $this->cari($id);

        $data = $request->validate([
            'name'     => ['required', 'max:100'],
            'email'    => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:6'],
        ], $this->pesan());

        // Password dikosongkan berarti tidak diganti
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route($this->rute() . '.index')
            ->with('sukses', $this->label . ' berhasil diubah.');
    }

    public function destroy($id)
    {
        $this->cari($id)->delete();

        return redirect()->route($this->rute() . '.index')
            ->with('sukses', $this->label . ' berhasil dihapus.');
    }

    private function pesan()
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'name.max'          => 'Nama maksimal 100 karakter.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ];
    }
}
