<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Lampiran;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// Controller untuk sisi customer
class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with('kategori')->withCount('lampirans')->latest();

        // Pencarian berdasarkan nama customer atau email
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%$cari%")
                  ->orWhere('email', 'like', "%$cari%");
            });
        }

        $pengaduans = $query->simplePaginate(10)->withQueryString();

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        $jumlahMeja = Pengaduan::JUMLAH_MEJA;

        return view('pengaduan.create', compact('kategoris', 'jumlahMeja'));
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        $pengaduan = Pengaduan::create($data);
        $this->simpanFoto($request, $pengaduan);

        return redirect()->route('pengaduan.index')->with('sukses', 'Pengaduan berhasil dikirim.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('kategori', 'lampirans');

        return view('pengaduan.show', compact('pengaduan'));
    }

    private function validasi(Request $request)
    {
        $idKategori = Kategori::pluck('id')->push('lainnya')->all();

        $aturan = [
            'nama'            => ['required', 'max:100'],
            'nomor_meja'      => ['required', 'integer', 'between:1,' . Pengaduan::JUMLAH_MEJA],
            'email'           => ['required', 'email', 'max:100'],
            'no_hp'           => ['required', 'regex:/^[0-9+]{8,14}$/'],
            'kategori_id'     => ['required', Rule::in($idKategori)],
            'kategori_manual' => ['required_if:kategori_id,lainnya', 'nullable', 'max:100'],
            'aduan'           => ['required'],
            'foto'            => ['nullable', 'array'],
            'foto.*'          => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        $pesan = [
            'nama.required'                => 'Nama customer wajib diisi.',
            'nomor_meja.required'          => 'Nomor meja wajib dipilih.',
            'nomor_meja.integer'           => 'Nomor meja tidak valid.',
            'nomor_meja.between'           => 'Nomor meja tidak tersedia.',
            'email.required'               => 'Email wajib diisi.',
            'email.email'                  => 'Format email tidak valid.',
            'no_hp.required'               => 'No HP wajib diisi.',
            'no_hp.regex'                  => 'No HP harus berupa angka (8 sampai 14 digit).',
            'kategori_id.required'         => 'Kategori wajib dipilih.',
            'kategori_id.in'               => 'Kategori tidak valid.',
            'kategori_manual.required_if'  => 'Isi kategori manual jika memilih Lainnya.',
            'aduan.required'               => 'Isi aduan wajib diisi.',
            'foto.*.image'                 => 'File harus berupa gambar.',
            'foto.*.mimes'                 => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.*.max'                   => 'Ukuran tiap foto maksimal 2 MB.',
        ];

        $data = $request->validate($aturan, $pesan);

        // Pilih "lainnya" berarti pakai kategori manual, kalau tidak kosongkan kategori manual
        if ($data['kategori_id'] === 'lainnya') {
            $data['kategori_id'] = null;
        } else {
            $data['kategori_manual'] = null;
        }

        unset($data['foto']);

        return $data;
    }

    // Simpan semua foto yang diupload
    private function simpanFoto(Request $request, Pengaduan $pengaduan)
    {
        if (! $request->hasFile('foto')) {
            return;
        }

        foreach ($request->file('foto') as $file) {
            $path = $file->store('lampiran', 'public');

            Lampiran::create([
                'pengaduan_id' => $pengaduan->id,
                'path'         => $path,
                'nama_asli'    => $file->getClientOriginalName(),
            ]);
        }
    }
}
