<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

// Controller untuk sisi petugas: menanggapi dan mengelola pengaduan
class PetugasPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with('kategori')->withCount('lampirans')->latest();

        // Pencarian berdasarkan nama atau email
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%")
                  ->orWhere('email', 'like', "%$cari%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->simplePaginate(10)->withQueryString();

        return view('petugas.pengaduan.index', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('kategori', 'lampirans');

        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    // Petugas hanya mengubah status dan memberi tanggapan
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $data = $request->validate([
            'status'    => ['required', Rule::in(['baru', 'diproses', 'selesai'])],
            'tanggapan' => ['nullable'],
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $pengaduan->update($data);

        return redirect()->route('petugas.pengaduan.show', $pengaduan)
            ->with('sukses', 'Tanggapan dan status berhasil disimpan.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        // Hapus semua file foto dari storage, barisnya ikut terhapus otomatis
        foreach ($pengaduan->lampirans as $foto) {
            Storage::disk('public')->delete($foto->path);
        }

        $pengaduan->delete();

        return redirect()->route('petugas.pengaduan.index')->with('sukses', 'Pengaduan berhasil dihapus.');
    }
}
