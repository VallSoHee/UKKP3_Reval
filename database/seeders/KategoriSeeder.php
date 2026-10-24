<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = ['Makanan & Minuman', 'Pelayanan', 'Kebersihan', 'Fasilitas', 'Harga'];

        foreach ($daftar as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}
