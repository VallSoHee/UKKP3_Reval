<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->simplePaginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => ['required', 'max:100', 'unique:kategoris,nama'],
            'deskripsi' => ['nullable'],
        ], $this->pesan());

        Kategori::create($data);

        return redirect()->route('kategori.index')->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama'      => ['required', 'max:100', Rule::unique('kategoris', 'nama')->ignore($kategori->id)],
            'deskripsi' => ['nullable'],
        ], $this->pesan());

        $kategori->update($data);

        return redirect()->route('kategori.index')->with('sukses', 'Kategori berhasil diubah.');
    }

    public function destroy(Kategori $kategori)
    {
        // Kategori yang sudah dipakai pengaduan tidak boleh dihapus
        if ($kategori->pengaduans()->exists()) {
            return redirect()->route('kategori.index')
                ->with('gagal', 'Kategori tidak bisa dihapus karena masih dipakai pengaduan.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('sukses', 'Kategori berhasil dihapus.');
    }

    private function pesan()
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.max'      => 'Nama kategori maksimal 100 karakter.',
            'nama.unique'   => 'Nama kategori sudah ada.',
        ];
    }
}
