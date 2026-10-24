<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    // Jumlah meja yang tersedia di cafe
    const JUMLAH_MEJA = 20;

    protected $fillable = [
        'nama',
        'nomor_meja',
        'email',
        'no_hp',
        'kategori_id',
        'kategori_manual',
        'aduan',
        'status',
        'tanggapan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lampirans()
    {
        return $this->hasMany(Lampiran::class);
    }

    // Nama kategori: dari tabel kategori, kalau tidak ada pakai yang manual
    public function getNamaKategoriAttribute()
    {
        return $this->kategori?->nama ?? $this->kategori_manual ?? '-';
    }
}
